<?php 
if($_POST['inspired_hidden'] == 'Y') {
    //Form data sent
    $dribbble_username = $_POST['inspired_dribbble'];
    update_option('inspired_dribbble', $dribbble_username);

    $lastfm_username = $_POST['inspired_lastfm_username'];
    update_option('inspired_lastfm_username', $lastfm_username);
    
    $lastfm_key = $_POST['inspired_lastfm_key'];
    update_option('inspired_lastfm_key', $lastfm_key);

    $tumblr_username = $_POST['inspired_tumblr_username'];
    update_option('inspired_tumblr_username', $tumblr_username);

    $dbpwd = $_POST['inspired_flickr'];
    update_option('inspired_flickr', $flickr);
    ?>
    <div class="updated">
        <p><strong><?php _e('Options saved.' ); ?></strong></p>
    </div>
    <?php
} else {
    //Normal page display
    $dribbble = get_option('inspired_dribbble');
    $lastfm_username = get_option('inspired_lastfm_username');
    $lastfm_key = get_option('inspired_lastfm_key');
    $tumblr = get_option('inspired_tumblr');
    $flickr = get_option('inspired_flickr');
}
?>

<div class="wrap">
    <?php    echo "<h2>" . __( 'inspired options', 'inspired_trdom' ) . "</h2>"; ?>

    <form name="inspired_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="inspired_hidden" value="Y">
        <?php    echo "<h4>" . __( 'Enter details of sites you wish to gather items from', 'inspired_trdom' ) . "</h4>"; ?>        
        <table cellspacing="0" cellpadding="0" border="0">
            <tr>
                <th>
                    <?php _e("dribbble: " ); ?>
                </th>
                <td>
                    <input type="text" name="inspired_dribbble" id="inspired_dribbble" value="<?php echo $dribbble_username; ?>" size="20" />
                </td>
                <td><label for="inspired_dribbble"><?php  _e("username"); ?></label></td>
            </tr>
            <tr>
                <th>
                    <?php _e("last.fm: " ); ?>
                </th>
                <td>
                    <input type="text" id="inspired_lastfm_username" name="inspired_lastfm_username" value="<?php echo $lastfm_username; ?>" size="20" />
                </td>
                <td><label for="inspired_lastfm_username"><?php  _e("username"); ?></label></td>
            </tr>
            <tr>
                <th>
                    &nbsp;
                </th>
                <td>
                    <input type="text" id="inspired_lastfm_key" name="inspired_lastfm_key" value="<?php echo $lastfm_key; ?>" size="20" />
                </td>
                <td><label for="inspired_lastfm_key"><?php  _e("api key"); ?></label></td>
            </tr>
            <tr>
                <th>
                    <label for=""><?php _e("tumblr: " ); ?></label>
                </th>
                <td>
                    <input type="text" name="inspired_tumblr_username" value="<?php echo $tumblr_username; ?>" size="20" />
                </td>
                <td><label for="inspired_tumblr_username"><?php  _e("username"); ?></label></td>
            </tr>
            <tr>
                <th>
                    <label for=""><?php _e("flickr: " ); ?></label>
                </th>
                <td>
                    <input type="text" name="inspired_flickr" value="<?php echo $flickr; ?>" size="20" />
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Update Options', 'inspired_trdom' ) ?>" />
        </p>
    </form>
</div>