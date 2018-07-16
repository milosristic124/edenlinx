<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class mailme extends Mailable
{
    use Queueable, SerializesModels;
    public $address = "";
    public $name = "";
    public $subject = "";
    public $type = "";
    public $info = array();

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($typ, $inf)
    {
        $this->address = "williamding131@outlook.com";
        $this->name = "EdenLinx";
        
        $this->type = $typ;
        $this->info = $inf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->type == "ADMIN_REGISTER_CUSTOMER")
        {
            $this->subject = "New customer is registered.";
            return $this->view('emails.admin_newcustomer', array('info'=>$this->info))
                ->from($this->address, $this->name)
                ->subject($this->subject);
        }
        else if ($this->type == "ADMIN_REGISTER_BUSINESS")
        {
            $this->subject = "New business is registered.";
            return $this->view('emails.admin_newbusiness', array('info'=>$this->info))
                ->from($this->address, $this->name)
                ->subject($this->subject);
        }
        else if ($this->type == "ADMIN_CONTACT_MESSAGE")
        {
            $this->subject = "New Contact Page Submission";
            return $this->view('emails.admin_newcontactmessage', array('info'=>$this->info))
                ->from($this->address, $this->name)
                ->subject($this->subject);
        }
        else if ($this->type == "BUSINESS_RECEIVE_NEWMESSAGE")
        {
            $this->subject = "You received new message from customer.";
            return $this->view('emails.business_receivemessage', array('info'=>$this->info))
                ->from($this->address, $this->name)
                ->subject($this->subject);
        }
        else if ($this->type == "BUSINESS_ACCEPT_PROJECT")
        {
            $this->subject = "Project is accepted by customer.";
            return $this->view('emails.business_acceptproject', array('info'=>$this->info))
                ->from($this->address, $this->name)
                ->subject($this->subject);
        }
        else if ($this->type == "BUSINESS_COMPLETE_PROJECT")
        {
            $this->subject = "You have new rating for completing project.";
            return $this->view('emails.business_completeproject', array('info'=>$this->info))
                ->from($this->address, $this->name)
                ->subject($this->subject);
        }
        else if ($this->type == "CUSTOMER_RECEIVE_NEWMESSAGE")
        {
            $this->subject = "You received new message from business.";
            return $this->view('emails.customer_receivemessage', array('info'=>$this->info))
                ->from($this->address, $this->name)
                ->subject($this->subject);
        }
        else if ($this->type == "CUSTOMER_RECEIVE_PROJECT")
        {
            $this->subject = "New project is posted by business.";
            return $this->view('emails.customer_receiveproject', array('info'=>$this->info))
                ->from($this->address, $this->name)
                ->subject($this->subject);
        }
        else if ($this->type == "CUSTOMER_COMPLETE_PROJECT")
        {
            $this->subject = "Project is marked as complete by business.";
            return $this->view('emails.customer_completeproject', array('info'=>$this->info))
                ->from($this->address, $this->name)
                ->subject($this->subject);
        }
        else if ($this->type == "ADMIN_PASSWORD_RESET")
        {
            $this->subject = "Your password is changed";
            return $this->view('emails.admin_passwordreset', array('info'=>$this->info))
                ->from($this->address, $this->name)
                ->subject($this->subject);
        }
        else
        {
            return $this->view('emails.mailme', array('info'=>$this->info))
                 ->from($this->address, $this->name)
                 ->subject($this->subject);
        }
    }
}
