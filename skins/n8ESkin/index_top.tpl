{assign var=unique_id value=1|mt_rand:4}

<section class="index">
    <div>
        {jrCore_image image="slide_`$unique_id`.jpg" width="1903" class="img_scale"}
    </div>

    <div class="overlay">
        <div class="wrap">
            <div class="row">
                <h1>{$_conf.n8ESkin_headline_1}</h1>
                <p>{$_conf.n8ESkin_headline_text}</p>
            </div>
        </div>
    </div>
    <div class="down">
        <a href="#"></a>
    </div>
</section>