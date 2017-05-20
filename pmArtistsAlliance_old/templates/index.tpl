<body style="background:#000;">

<style type="text/css">
    img.bg {
        min-height: 100%;
        min-width: 1024px;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
    }
    .wrap {
        position: absolute;
        top: 50px;
        left: 500px;
        width: 600px;
    }
    .message {
        margin: 12px;
        font-size: 18px;
        color: #FFF;
        text-shadow: 1px 1px 1px #000;
    }
    .content {
        zoom: 1;
        margin: 12px;
        opacity: 1;
        border-radius: 12px;
    }
    .content h1 {
        font-size: 48px;
        padding: 0;
        color: #FFF;
        text-align: center;
        text-shadow: 1px 1px 1px #000;
    }
    .login_link {
        display: inline-block;
        margin: 36px 0 0 12px;
        font-size: 14px;
        text-shadow: 1px 1px 1px #000;
    }
    .login_link a {
        color: #FFF;
    }
    .login_link a:hover {
        text-decoration: none;
    }

    @media screen and (max-width: 1024px) {
        img.bg {
            left: 50%;
            margin-left: -512px;
        }
        .wrap {
            top: 0;
            left: 0;
            width: 100%;
        }
        .message {
            font-size: 14px;
        }
        .content h1 {
            font-size: 28px;
        }
    }
</style>

{jrCore_image module="pmArtistsAlliance" image="background.jpg" class="bg" alt=""}

<div class="wrap">

    <div class="content">
        <h1>{"Welcome To The Artist Alliance Sign-Up Page."}</h1>
    </div>

    <div class="message">
        {jrCore_lang module="pmArtistsAlliance" id=125 default="The Artist's Alliance are for artists who wish to offer band marketing and support to other artists in radio, fan-sharing or tour support."}<br /><br />
       {"If your interested in supporting another artist or having one support you, going on tour to areas where other artists are more established, or just feel like sharing your music with similar artists,  then hit the Artist Signup button, otherwise hit Exit"}
    </div>

    <div class="login_link">
        {jrCore_module_url module="pmArtistsAlliance" assign="url"}
            <br><a href="{$jamroom_url}/{$url}/signup">{jrCore_lang module="pmArtistsAlliance" id=111 default="Click Here to Create an Account"}</a>
        <br/>
        <br/>
        <b> <a href="{$jamroom_url}/">{jrCore_lang module="pmArtistsAlliance" id=126 default="Exit"}</a></b><br/>
    </div>

</div>

