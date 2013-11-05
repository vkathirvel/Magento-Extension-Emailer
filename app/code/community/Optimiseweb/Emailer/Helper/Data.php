<?php

/**
 * Optimiseweb Emailer Data Helper
 *
 * @package     Optimiseweb_Emailer
 * @author      Sid Vel (sid@optimiseweb.co.uk)
 * @copyright  Copyright (c) 2013 Optimise Web Limited
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Emailer_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * Function to send emails
     *
     * @param type $emailSenderName
     * @param type $emailSenderEmail
     * @param type $emailRecipientName
     * @param type $emailRecipientEmail
     * @param type $emailReplyTo
     * @param type $emailCC
     * @param type $emailBCC
     * @param type $emailSubject
     * @param type $emailVariables
     * @param type $emailAttachment
     * @param type $emailTemplate
     * @return boolean
     * @throws Exception
     */
    public function sendEmails($emailSenderName, $emailSenderEmail, $emailRecipientName, $emailRecipientEmail, $emailReplyTo = NULL, $emailCC = NULL, $emailBCC = NULL, $emailSubject = NULL, $emailVariables, $emailAttachment = NULL, $emailTemplate) {
        $storeId = Mage::app()->getStore()->getId();

        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);

        $emailModel = Mage::getModel('core/email_template');
        $emailModel->setDesignConfig(array('area' => 'frontend'));

        $emailSender = array(
            'name' => $emailSenderName,
            'email' => $emailSenderEmail
        );

        if (isset($emailReplyTo) AND ($emailReplyTo != FALSE))
            $emailModel->setReplyTo($emailReplyTo);

        /* There are a three ways you can add CC recipients. */
        /* $emailModel->addCc('user@email.com'); */
        /* $emailModel->addCc('user@email.com', 'John Doe'); */
        /* $emailModel->addCc(array('John Doe' => 'user@email.com')); */
        if (isset($emailCC) AND ($emailCC != FALSE))
            $emailModel->getMail()->addCc($emailCC);

        /* There are two ways you can add BCC recipients. */
        /* $emailModel->addBcc('user@email.com'); */
        /* $emailModel->addBcc(array('user@email.com', 'user1@email.com')); */
        if (isset($emailBCC) AND ($emailBCC != FALSE))
            $emailModel->getMail()->addBcc($emailBCC);

        if (isset($emailSubject) AND ($emailSubject != FALSE))
            $emailModel->setTemplateSubject($emailSubject);

        if (isset($emailAttachment) AND ($emailAttachment != FALSE)) {
            foreach ($emailAttachment as $attachment) {
                $emailModel->getMail()->createAttachment($attachment['content'], $attachment['mime'])->filename = $attachment['filename'];
            }
        }

        $emailModel->sendTransactional($emailTemplate, $emailSender, $emailRecipientEmail, $emailRecipientName, $emailVariables, $storeId);

        if (!$emailModel->getSentSuccess()) {
            throw new Exception();
        }

        $translate->setTranslateInline(true);

        return TRUE;
    }

    /**
     * IN PROGRESS DO NOT USE
     *
     * @param type $emailDataObject
     * @return type
     */
    public function simpleSendEmails($emailDataObject) {
        if ($emailDataObject->senderName) {
            $emailSenderName = $emailDataObject->senderName;
        }
        if ($emailDataObject->senderEmail) {
            $emailSenderEmail = $emailDataObject->senderEmail;
        }
        if ($emailDataObject->recipientName) {
            $emailRecipientName = $emailDataObject->recipientName;
        }
        if ($emailDataObject->recipientEmail) {
            $emailRecipientEmail = $emailDataObject->recipientEmail;
        }
        if ($emailDataObject->replyTo) {
            $emailReplyTo = $emailDataObject->replyTo;
        } else {
            $emailReplyTo = NULL;
        }
        if ($emailDataObject->cc) {
            $emailCC = $emailDataObject->cc;
        } else {
            $emailCC = NULL;
        }
        if ($emailDataObject->bcc) {
            $emailBCC = $emailDataObject->bcc;
        } else {
            $emailBCC = NULL;
        }
        if ($emailDataObject->subject) {
            $emailSubject = $emailDataObject->subject;
        } else {
            $emailSubject = NULL;
        }
        if ($emailDataObject->variables) {
            $emailVariables = $emailDataObject->variables;
        }
        if ($emailDataObject->attachment) {
            $emailAttachment = $emailDataObject->attachment;
        } else {
            $emailAttachment = NULL;
        }
        if ($emailDataObject->template) {
            $emailTemplate = $emailDataObject->template;
        } else {
            $emailTemplate = 'standard_text_email_template';
        }

        $this->sendEmails($emailSenderName, $emailSenderEmail, $emailRecipientName, $emailRecipientEmail, $emailReplyTo, $emailCC, $emailBCC, $emailSubject, $emailVariables, $emailAttachment, $emailTemplate);

        return;
    }

    /**
     * Function to send all sorts of emails
     *
     * Mage::helper('emailer')->sendEmail('Sender Name', 'sender@email.com', 'Recipient Name', 'recipient@email.com', 'Email Subject', $emailVariables = array('content' => 'Something'), $emailTemplate = 'standard_html_email_template');
     *
     * @param type $emailSenderName
     * @param type $emailSenderEmail
     * @param type $emailRecipientName
     * @param type $emailRecipientEmail
     * @param type $emailSubject
     * @param type $emailVariables
     * @param type $emailTemplate
     * @return boolean
     * @throws Exception
     */
    public function sendEmail($emailSenderName, $emailSenderEmail, $emailRecipientName, $emailRecipientEmail, $emailSubject, $emailVariables, $emailTemplate = 'standard_html_email_template') {
        $storeId = Mage::app()->getStore()->getId();

        $emailSender = array(
            'name' => $emailSenderName,
            'email' => $emailSenderEmail
        );

        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);

        $emailModel = Mage::getModel('core/email_template');
        $emailModel->setTemplateSubject($emailSubject);
        $emailModel->setDesignConfig(array('area' => 'frontend'));
        $emailModel->sendTransactional($emailTemplate, $emailSender, $emailRecipientEmail, $emailRecipientName, $emailVariables, $storeId);

        if (!$emailModel->getSentSuccess()) {
            throw new Exception();
        }

        $translate->setTranslateInline(true);

        return TRUE;
    }

}
