
{assign var=unique_id value=1|mt_rand:5}
{if $_conf.n8MSkinX_randomize == 'off'}
    {assign var=unique_id value=$_conf.n8MSkinX_default_video}
{/if}

<div class="video_wrapper">
    <video autoplay="true" loop="true" muted="true" poster="{$jamroom_url}/skins/n8MSkinX/video_bgs/placeholder_{$unique_id}.jpg" id="background">
        <source src="{$jamroom_url}/skins/n8MSkinX/video_bgs/{$unique_id}.mp4?_v={$smarty.now}" type="video/mp4">
        <source src="{$jamroom_url}/skins/n8MSkinX/video_bgs/{$unique_id}.webm?_v={$smarty.now}" type="video/webm">
    </video>
</div>