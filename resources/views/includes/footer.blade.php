
<div class="container">
    <div class="row">
        <div class="col-md-5 col-sm-6">
            <img class="footer-logo" src="{{asset('images/logo.png')}}" alt="">
            <br><br>
            <p id="p_aboutus"></p>
        </div>

        <div class="col-md-4 col-sm-6 ">
            <h4>Links</h4>
            <ul class="footer-links">
                <li><a href="{{url('/')}}"><p class="redtext"> Home</p></a></li>
                <li><a href="{{url('category')}}"><p class="redtext"> Categories</p></a></li>
                <li><a href="{{url('/contact')}}"><p class="redtext"> Contact</p></a></li>
                @if(Auth::check())
                    <li><a href="{{url('business')}}"><p class="redtext"> Add Your Business</p></a></li>
                @else
                    <li><a href="#business-sign-in-dialog" class="sign-in popup-with-zoom-anim"><p class="redtext"> Add Your Business</p></a></li>
                @endif
                <li>
                    @if(Auth::check())
                        @if(Auth::user()->userrole == 'customer')
                            <a href="{{url('dashboard')}}"><p class="redtext"> My Account</p></a>
                        @else
                            <a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim"><p class="redtext"> Login</p></a>
                        @endif
                    @else
                        <a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim"><p class="redtext"> Login</p></a>
                    @endif
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="col-md-3  col-sm-12">
            <h4>Contact Us</h4>
            <div class="text-widget">
                <span>EDENLINX Australia Pty Ltd</span> <br>
                <span>PO 3123 Wetherill Park 2164 NSW</span><br>
                <span> <a href="#">info@edenlinx.com</a> </span><br>
            </div>

            <ul class="social-icons margin-top-20">
                <li><a class="facebook" href="#"><i class="icon-facebook"></i></a></li>
                <li><a class="twitter" href="#"><i class="icon-twitter"></i></a></li>
                <li><a class="gplus" href="#"><i class="icon-gplus"></i></a></li>
                <li><a class="vimeo" href="#"><i class="icon-vimeo"></i></a></li>
            </ul>

        </div>

    </div>
    <div class="footer1">
        <hr>
        <a href="{{url('privacy')}}"><span class="redtext"> Privacy Policy</span></a> /
        <a href="{{url('terms')}}"><span class="redtext"> Terms and Conditions</span></a>
    </div>

    <!-- Copyright -->
    <div class="row">
        <div class="col-md-12">
            <div class="copyrights">Copyright Edenlinx 2017. All rights reserved.<br>Created by <a href="http://emoceanstudios.com.au" target="_blank" style="color: #f91942;">emoceanstudios.com.au.</a></div>
        </div>
    </div>

</div>

</div>

<script>
    $(document).ready(function(){
        $.ajax({
            url: "{{url('/getaboutus')}}",
            type: "GET",
            async : true,
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#p_aboutus").html("Some about us information with keywords and keyphrases to help with SEO and users to better understand what EDENLINX is capable of.");
            },
            success: function (data) {
                obj = $.parseJSON(data);
                $("#p_aboutus").html(obj.data);
            }
        });
    });
</script>