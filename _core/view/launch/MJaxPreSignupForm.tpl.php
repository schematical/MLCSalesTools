<style type="text/css">
    body {

        background-color: #000;
    }

    .form-signin {
        max-width: 450px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
    }
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
        margin-bottom: 10px;
    }
    .form-signin input[type="text"],
    .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
    }
        /*body{
            background-image:url('http:<?php echo MLCApplication::GetAssetUrl('/imgs/bkgd.jpg'); ?>');
    }*/
    .imgBkgd{
        z-index: 200;
    }
    #divMain{
        padding-top: 40px;
        padding-bottom: 40px;
        z-index: 100;
    }
    #divHolder{
        position:fixed;
        width: 100%;
    }
    #divImgHolder{
        position:fixed;
        height:100%;
        overflow:hidden;
    }
    .navbar-inner{
        padding:3px;
        min-height: 29px;
    }
    .navbar-inner a{
        float:right;
        margin-right:50Px;
    }
</style>


<div id='divHolder'>
    <div id='divMain' class="container">

        <form class="form-signin">
            <h1>Launching Soon:</h1>
            <div class='well' style='text-align: center'>
                <h3 id='h2Headline' class="form-signin-heading">
                    <?php $this->RenderRandomHeadline(); ?>
                </h3>

                <div class='divBody'>
                    <?php $this->RenderRandomBody(); ?>
                </div>
            </div>
            <?php
            $this->txtEmail->Render();
            foreach($this->arrExtraFields as $strSaveAs => $ctlSignup){
                $ctlSignup->Render();
            } ?>
            <?php $this->RenderSignUpButton(); ?>
            <div style='clear:both;'></div>
        </form>

    </div> <!-- /container -->
</div>
<div class='divImgHolder'>
    <img class='imgBkgd' src='<?php $this->RenderRandomBackground(); ?>' />
</div>
<div class="navbar navbar-fixed-bottom">
    <div class="navbar-inner">
       <?php foreach($this->arrFooterLinks as $strKey => $lnkFooter){ ?>
            <?php $lnkFooter->Render(); ?>
       <?php } ?>
    </div>
</div>
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-25112886-1']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>