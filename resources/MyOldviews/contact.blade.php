@extends('layouts.master')
@section('title', 'Contact')
@section('content')
    <!--<div class="container">-->
        <div class="main-search-container margin-bottom-60" id="contact-main-image" data-background-image="{{asset('images/contactback.png')}}">
    </div>
    <!--</div>-->
    
    <div class="container">

        <div class="row">

            <!-- Contact Details -->
            <div class="col-md-4">

                <h4 class="headline margin-bottom-30">Contact Us</h4>

                <!-- Contact Details -->
                <div class="sidebar-textbox">
                    <p>If you have any questions at all, please get in touch, we are here to help and it's best you know what all your options are for your situation and roofing size.</p>

                    <ul class="contact-details">
                        <li><i class="im im-icon-phone contact-icon"></i><a><p> 0424 646 929 </p></a></li>
                        <li><i class="im im-icon-email contact-icon"></i><a><p> info@edenlinx.com </p></a></li>
                    </ul>
                </div>

            </div>
            <!-- Contact Form -->
            <div class="col-md-8">

                <section id="contact">
                    <h4 class="headline margin-bottom-35">Contact Form</h4>

                    <div id="contact-message"></div>

                    <form method="post" action="contact.php" name="contactform" id="contactform" autocomplete="on">

                        <div class="row">
                            <div class="col-md-6">
                                <div>
                                    <input name="name" type="text" id="name" placeholder="Your Name" required="required" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div>
                                    <input name="email" type="email" id="email" placeholder="Email Address" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" required="required" />
                                </div>
                            </div>
                        </div>

                        <div>
                            <input name="subject" type="text" id="subject" placeholder="Subject" required="required" />
                        </div>

                        <div>
                            <textarea name="comments" cols="40" rows="3" id="comments" placeholder="Message" spellcheck="true" required="required"></textarea>
                        </div>

                        <input type="submit" class="submit button" id="submit" value="Submit Message" />

                    </form>
                </section>
            </div>
            <!-- Contact Form / End -->

        </div>

    </div>

@endsection