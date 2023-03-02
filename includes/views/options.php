<?php
/**
  * @author Guillermo Challiol
  * @author Guillermo Challiol  <guillermochalliol@gmail.com>
  */
if ( ! defined('ABSPATH') ) {
    die('Direct access not permitted.');
}

/**
 * 
 * Admin Page Callback // create Options page
 *
 */
function footnotes_options() {
  // check user capabilities
  if ( ! current_user_can( 'manage_options' ) ) {
    return;
  }

  $default_tab = null;
  $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;

  ?>
  <div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <nav class="nav-tab-wrapper">
      <a href="?page=footnotes" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">FootNotes</a>
      <a href="?page=footnotes&tab=link-checker" class="nav-tab <?php if($tab==='link-checker'):?>nav-tab-active<?php endif; ?>">Link Checker</a>
    </nav>

    <div class="tab-content">
    <?php switch($tab) :
    //link Checker Tab
      case 'link-checker':
        ?>
        <h2>Post Links Scanner</h2>
        <p>Press button to scan all posts links</p>
        <button id="scan">Scan Posts</button>
        <table id="linksTable" class="cell-border compact stripe" style="display:none; width:100%;">
          <thead>
            <tr>
              <th>URL</th>
              <th>Status</th>
              <th>Source</th>
            </tr>
          </thead>
          <tbody></tbody>		
        </table><?php
        break;
      default:
      //footnotes  tab -> add the capability to decide if you want to show on post  and/or  pages
      ?>
      <form method="post" action="options.php">
        <?php settings_fields( 'footnotes_options' ); ?>
        <?php $post = get_option( 'post_type_post' ); 
              $page = get_option( 'post_type_page' );
        ?>
        <p class="form-field">
          <label for="post_type_post">Show Footnote in Posts:</label>
          <input type="checkbox" id="post_type_post"  name="post_type_post" value="1" <?php checked( 1, $post, true ) ?>/>
        </p>
         <p class="form-field">
          <label for="post_type_post">Show Footnote in Pages:</label>
          <input type="checkbox" id="post_type_page"  name="post_type_page" value="1" <?php checked( 1, $page, true ) ?>/>
        </p>
        <?php submit_button('Save Footnotes Settings'); ?>
    </form>
      <?php
        break;
    endswitch; ?>
    </div>
  </div>
  <?php
}

