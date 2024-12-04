<?php
/**
 * Theme file editor administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once __DIR__ . '/admin.php';

if ( is_multisite() && ! is_network_admin() ) {
	wp_redirect( network_admin_url( 'theme-editor.php' ) );
	exit;
}

if ( ! current_user_can( 'edit_themes' ) ) {
	wp_die( '<p>' . __( 'Xin lỗi, bạn không được phép chỉnh sửa giao diện cho trang web này.' ) . '</p>' );
}

// Used in the HTML title tag.
$title       = __( 'Chỉnh sửa giao diện' );
$parent_file = 'themes.php';

get_current_screen()->add_help_tab(
	array(
		'id'      => 'overview',
		'title'   => __( 'Tổng quan' ),
		'content' =>
				'<p>' . __( 'Bạn có thể sử dụng trình chỉnh sửa tập tin giao diện để chỉnh sửa các tập tin CSS và PHP riêng lẻ tạo nên giao diện của bạn.' ) . '</p>' .
				'<p>' . __( 'Bắt đầu bằng cách chọn một giao diện để chỉnh sửa từ menu thả xuống và nhấp vào nút Chọn. Sau đó, một danh sách các tập tin mẫu của giao diện sẽ xuất hiện. Nhấp một lần vào bất kỳ tên tập tin nào sẽ khiến tập tin xuất hiện trong hộp Trình chỉnh sửa lớn.' ) . '</p>' .
				'<p>' . __( 'Đối với các tập tin PHP, bạn có thể sử dụng menu thả xuống tài liệu để chọn từ các hàm được nhận dạng trong tập tin đó. Tra cứu sẽ đưa bạn đến một trang web với tài liệu tham khảo về hàm cụ thể đó.' ) . '</p>' .
				'<p id="editor-keyboard-trap-help-1">' . __( 'Khi sử dụng bàn phím để điều hướng:' ) . '</p>' .
				'<ul>' .
				'<li id="editor-keyboard-trap-help-2">' . __( 'Trong khu vực chỉnh sửa, phím Tab nhập một ký tự tab.' ) . '</li>' .
				'<li id="editor-keyboard-trap-help-3">' . __( 'Để di chuyển ra khỏi khu vực này, nhấn phím Esc sau đó nhấn phím Tab.' ) . '</li>' .
				'<li id="editor-keyboard-trap-help-4">' . __( 'Người dùng trình đọc màn hình: khi ở chế độ biểu mẫu, bạn có thể cần nhấn phím Esc hai lần.' ) . '</li>' .
				'</ul>' .
				'<p>' . __( 'Sau khi nhập các chỉnh sửa của bạn, nhấp vào Cập nhật tập tin.' ) . '</p>' .
				'<p>' . __( '<strong>Lời khuyên:</strong> Hãy suy nghĩ kỹ về việc trang web của bạn có thể bị lỗi nếu bạn chỉnh sửa trực tiếp giao diện đang được sử dụng.' ) . '</p>' .
				'<p>' . sprintf(
					/* translators: %s: Link to documentation on child themes. */
					__( 'Nâng cấp lên phiên bản mới hơn của cùng một giao diện sẽ ghi đè các thay đổi được thực hiện ở đây. Để tránh điều này, hãy cân nhắc tạo một <a href="%s">giao diện con</a> thay thế.' ),
					__( 'https://developer.wordpress.org/themes/advanced-topics/child-themes/' )
				) . '</p>' .
				( is_network_admin() ? '<p>' . __( 'Bất kỳ chỉnh sửa nào đối với các tập tin từ màn hình này sẽ được phản ánh trên tất cả các trang web trong mạng.' ) . '</p>' : '' ),
	)
);

get_current_screen()->set_help_sidebar(
	'<p><strong>' . __( 'Để biết thêm thông tin:' ) . '</strong></p>' .
	'<p>' . __( '<a href="https://developer.wordpress.org/themes/">Tài liệu về Phát triển Giao diện</a>' ) . '</p>' .
	'<p>' . __( '<a href="https://wordpress.org/documentation/article/appearance-theme-file-editor-screen/">Tài liệu về Chỉnh sửa Giao diện</a>' ) . '</p>' .
	'<p>' . __( '<a href="https://developer.wordpress.org/advanced-administration/wordpress/edit-files/">Tài liệu về Chỉnh sửa Tập tin</a>' ) . '</p>' .
	'<p>' . __( '<a href="https://developer.wordpress.org/themes/basics/template-tags/">Tài liệu về Thẻ Mẫu</a>' ) . '</p>' .
	'<p>' . __( '<a href="https://wordpress.org/support/forums/">Diễn đàn hỗ trợ</a>' ) . '</p>'
);

$action = ! empty( $_REQUEST['action'] ) ? sanitize_text_field( $_REQUEST['action'] ) : '';
$theme  = ! empty( $_REQUEST['theme'] ) ? sanitize_text_field( $_REQUEST['theme'] ) : '';
$file   = ! empty( $_REQUEST['file'] ) ? sanitize_text_field( $_REQUEST['file'] ) : '';
$error  = ! empty( $_REQUEST['error'] );

if ( $theme ) {
	$stylesheet = $theme;
} else {
	$stylesheet = get_stylesheet();
}

$theme = wp_get_theme( $stylesheet );

if ( ! $theme->exists() ) {
	wp_die( __( 'Giao diện được yêu cầu không tồn tại.' ) );
}

if ( $theme->errors() && 'theme_no_stylesheet' === $theme->errors()->get_error_code() ) {
	wp_die( __( 'Giao diện được yêu cầu không tồn tại.' ) . ' ' . $theme->errors()->get_error_message() );
}

$allowed_files = array();
$style_files   = array();

$file_types = wp_get_theme_file_editable_extensions( $theme );

foreach ( $file_types as $type ) {
	switch ( $type ) {
		case 'php':
			$allowed_files += $theme->get_files( 'php', -1 );
			break;
		case 'css':
			$style_files                = $theme->get_files( 'css', -1 );
			$allowed_files['style.css'] = $style_files['style.css'];
			$allowed_files             += $style_files;
			break;
		default:
			$allowed_files += $theme->get_files( $type, -1 );
			break;
	}
}

// Move functions.php and style.css to the top.
if ( isset( $allowed_files['functions.php'] ) ) {
	$allowed_files = array( 'functions.php' => $allowed_files['functions.php'] ) + $allowed_files;
}
if ( isset( $allowed_files['style.css'] ) ) {
	$allowed_files = array( 'style.css' => $allowed_files['style.css'] ) + $allowed_files;
}

if ( empty( $file ) ) {
	$relative_file = 'style.css';
	$file          = $allowed_files['style.css'];
} else {
	$relative_file = wp_unslash( $file );
	$file          = $theme->get_stylesheet_directory() . '/' . $relative_file;
}

validate_file_to_edit( $file, $allowed_files );

// Handle fallback editing of file when JavaScript is not available.
$edit_error     = null;
$posted_content = null;

if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
	$r = wp_edit_theme_plugin_file( wp_unslash( $_POST ) );
	if ( is_wp_error( $r ) ) {
		$edit_error = $r;
		if ( check_ajax_referer( 'edit-theme_' . $stylesheet . '_' . $relative_file, 'nonce', false ) && isset( $_POST['newcontent'] ) ) {
			$posted_content = wp_unslash( $_POST['newcontent'] );
		}
	} else {
		wp_redirect(
			add_query_arg(
				array(
					'a'     => 1, // This means "success" for some reason.
					'theme' => $stylesheet,
					'file'  => $relative_file,
				),
				admin_url( 'theme-editor.php' )
			)
		);
		exit;
	}
}

$settings = array(
	'codeEditor' => wp_enqueue_code_editor( compact( 'file' ) ),
);
wp_enqueue_script( 'wp-theme-plugin-editor' );
wp_add_inline_script( 'wp-theme-plugin-editor', sprintf( 'jQuery( function( $ ) { wp.themePluginEditor.init( $( "#template" ), %s ); } )', wp_json_encode( $settings ) ) );
wp_add_inline_script( 'wp-theme-plugin-editor', 'wp.themePluginEditor.themeOrPlugin = "theme";' );

require_once ABSPATH . 'wp-admin/admin-header.php';

update_recently_edited( $file );

if ( ! is_file( $file ) ) {
	$error = true;
}

$content = '';
if ( ! empty( $posted_content ) ) {
	$content = $posted_content;
} elseif ( ! $error && filesize( $file ) > 0 ) {
	$f       = fopen( $file, 'r' );
	$content = fread( $f, filesize( $file ) );

	if ( str_ends_with( $file, '.php' ) ) {
		$functions = wp_doc_link_parse( $content );

		if ( ! empty( $functions ) ) {
			$docs_select  = '<select name="docs-list" id="docs-list">';
			$docs_select .= '<option value="">' . esc_html__( 'Tên hàm...' ) . '</option>';

			foreach ( $functions as $function ) {
				$docs_select .= '<option value="' . esc_attr( $function ) . '">' . esc_html( $function ) . '()</option>';
			}

			$docs_select .= '</select>';
		}
	}

	$content = esc_textarea( $content );
}

$file_description = get_file_description( $relative_file );
$file_show        = array_search( $file, array_filter( $allowed_files ), true );
$description      = esc_html( $file_description );
if ( $file_description !== $file_show ) {
	$description .= ' <span>(' . esc_html( $file_show ) . ')</span>';
}
?>
<div class="wrap">
<h1><?php echo esc_html( $title ); ?></h1>

<?php
if ( isset( $_GET['a'] ) ) {
	wp_admin_notice(
		__( 'Tập tin đã được chỉnh sửa thành công.' ),
		array(
			'id'                 => 'message',
			'dismissible'        => true,
			'additional_classes' => array( 'updated' ),
		)
	);
} elseif ( is_wp_error( $edit_error ) ) {
	$error_code = esc_html( $edit_error->get_error_message() ? $edit_error->get_error_message() : $edit_error->get_error_code() );
	$message    = '<p>' . __( 'Đã xảy ra lỗi khi cố gắng cập nhật tập tin. Bạn có thể cần sửa một số thứ và thử cập nhật lại.' ) . '</p>
	<pre>' . $error_code . '</pre>';
	wp_admin_notice(
		$message,
		array(
			'type' => 'error',
			'id'   => 'message',
		)
	);
}

if ( preg_match( '/\.css$/', $file ) && ! wp_is_block_theme() && current_user_can( 'customize' ) ) {
	$message = '<p><strong>' . __( 'Bạn có biết?' ) . '</strong></p><p>' . sprintf(
		/* translators: %s: Link to Custom CSS section in the Customizer. */
		__( 'Không cần thay đổi CSS của bạn ở đây &mdash; bạn có thể chỉnh sửa và xem trước trực tiếp các thay đổi CSS trong <a href="%s">trình chỉnh sửa CSS tích hợp</a>.' ),
		esc_url( add_query_arg( 'autofocus[section]', 'custom_css', admin_url( 'customize.php' ) ) )
	) . '</p>';
	wp_admin_notice(
		$message,
		array(
			'type' => 'info',
			'id'   => 'message',
		)
	);
}
?>

<div class="fileedit-sub">
<div class="alignleft">
<h2>
	<?php
	echo $theme->display( 'Name' );
	if ( $description ) {
		echo ': ' . $description;
	}
	?>
</h2>
</div>
<div class="alignright">
	<form action="theme-editor.php" method="get">
		<label for="theme" id="theme-plugin-editor-selector"><?php _e( 'Chọn giao diện để chỉnh sửa:' ); ?> </label>
		<select name="theme" id="theme">
		<?php
		foreach ( wp_get_themes( array( 'errors' => null ) ) as $a_stylesheet => $a_theme ) {
			if ( $a_theme->errors() && 'theme_no_stylesheet' === $a_theme->errors()->get_error_code() ) {
				continue;
			}

			$selected = ( $a_stylesheet === $stylesheet ) ? ' selected="selected"' : '';
			echo "\n\t" . '<option value="' . esc_attr( $a_stylesheet ) . '"' . $selected . '>' . $a_theme->display( 'Name' ) . '</option>';
		}
		?>
		</select>
		<?php submit_button( __( 'Chọn' ), '', 'Submit', false ); ?>
	</form>
</div>
<br class="clear" />
</div>

<?php
if ( $theme->errors() ) {
	wp_admin_notice(
		'<strong>' . __( 'Giao diện này bị lỗi.' ) . '</strong> ' . $theme->errors()->get_error_message(),
		array(
			'additional_classes' => array( 'error' ),
		)
	);
}
?>

<div id="templateside">
	<h2 id="theme-files-label"><?php _e( 'Tập tin Giao diện' ); ?></h2>
	<ul role="tree" aria-labelledby="theme-files-label">
		<?php if ( $theme->parent() ) : ?>
			<li class="howto">
				<?php
				printf(
					/* translators: %s: Link to edit parent theme. */
					__( 'Giao diện con này kế thừa mẫu từ giao diện cha, %s.' ),
					sprintf(
						'<a href="%s">%s</a>',
						self_admin_url( 'theme-editor.php?theme=' . urlencode( $theme->get_template() ) ),
						$theme->parent()->display( 'Name' )
					)
				);
				?>
			</li>
		<?php endif; ?>
		<li role="treeitem" tabindex="-1" aria-expanded="true" aria-level="1" aria-posinset="1" aria-setsize="1">
			<ul role="group">
				<?php wp_print_theme_file_tree( wp_make_theme_file_tree( $allowed_files ) ); ?>
			</ul>
		</li>
	</ul>
</div>

<?php
if ( $error ) :
	wp_admin_notice(
		__( 'Tập tin không tồn tại! Vui lòng kiểm tra lại tên và thử lại.' ),
		array(
			'additional_classes' => array( 'error' ),
		)
	);
else :
	?>
	<form name="template" id="template" action="theme-editor.php" method="post">
		<?php wp_nonce_field( 'edit-theme_' . $stylesheet . '_' . $relative_file, 'nonce' ); ?>
		<div>
			<label for="newcontent" id="theme-plugin-editor-label"><?php _e( 'Nội dung tập tin đã chọn:' ); ?></label>
			<textarea cols="70" rows="30" name="newcontent" id="newcontent" aria-describedby="editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4"><?php echo $content; ?></textarea>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="file" value="<?php echo esc_attr( $relative_file ); ?>" />
			<input type="hidden" name="theme" value="<?php echo esc_attr( $theme->get_stylesheet() ); ?>" />
		</div>

		<?php if ( ! empty( $functions ) ) : ?>
			<div id="documentation" class="hide-if-no-js">
				<label for="docs-list"><?php _e( 'Tài liệu:' ); ?></label>
				<?php echo $docs_select; ?>
				<input disabled id="docs-lookup" type="button" class="button" value="<?php esc_attr_e( 'Tra cứu' ); ?>" onclick="if ( '' !== jQuery('#docs-list').val() ) { window.open( 'https://api.wordpress.org/core/handbook/1.0/?function=' + escape( jQuery( '#docs-list' ).val() ) + '&amp;locale=<?php echo urlencode( get_user_locale() ); ?>&amp;version=<?php echo urlencode( get_bloginfo( 'version' ) ); ?>&amp;redirect=true'); }" />
			</div>
		<?php endif; ?>

		<div>
			<div class="editor-notices">
				<?php
				if ( is_child_theme() && $theme->get_stylesheet() === get_template() ) :
					$message  = ( is_writable( $file ) ) ? '<strong>' . __( 'Cảnh báo:' ) . '</strong> ' : '';
					$message .= __( 'Đây là một tập tin trong giao diện cha hiện tại của bạn.' );
					wp_admin_notice(
						$message,
						array(
							'type'               => 'warning',
							'additional_classes' => array( 'inline' ),
						)
					);
				endif;
				?>
			</div>
			<?php
			if ( is_writable( $file ) ) {
				?>
				<p class="submit">
					<?php submit_button( __( 'Cập nhật Tập tin' ), 'primary', 'submit', false ); ?>
					<span class="spinner"></span>
				</p>
				<?php
			} else {
				?>
				<p>
					<?php
					printf(
						/* translators: %s: Documentation URL. */
						__( 'Bạn cần làm cho tập tin này có thể ghi được trước khi có thể lưu các thay đổi của bạn. Xem <a href="%s">Thay đổi Quyền Tập tin</a> để biết thêm thông tin.' ),
						__( 'https://developer.wordpress.org/advanced-administration/server/file-permissions/' )
					);
					?>
				</p>
				<?php
			}
			?>
		</div>

		<?php wp_print_file_editor_templates(); ?>
	</form>
	<?php
endif; // End if $error.
?>
<br class="clear" />
</div>
<?php
$dismissed_pointers = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
if ( ! in_array( 'theme_editor_notice', $dismissed_pointers, true ) ) {
	// Get a back URL.
	$referer = wp_get_referer();

	$excluded_referer_basenames = array( 'theme-editor.php', 'wp-login.php' );

	$return_url = admin_url( '/' );
	if ( $referer ) {
		$referer_path = parse_url( $referer, PHP_URL_PATH );
		if ( is_string( $referer_path ) && ! in_array( basename( $referer_path ), $excluded_referer_basenames, true ) ) {
			$return_url = $referer;
		}
	}
	?>
	<div id="file-editor-warning" class="notification-dialog-wrap file-editor-warning hide-if-no-js hidden">
		<div class="notification-dialog-background"></div>
		<div class="notification-dialog">
			<div class="file-editor-warning-content">
				<div class="file-editor-warning-message">
					<h1><?php _e( 'Chú ý!' ); ?></h1>
					<p>
						<?php
						_e( 'Có vẻ như bạn đang thực hiện chỉnh sửa trực tiếp giao diện trong bảng điều khiển WordPress. Điều này không được khuyến nghị! Chỉnh sửa trực tiếp giao diện của bạn có thể làm hỏng trang web và các thay đổi của bạn có thể bị mất trong các bản cập nhật trong tương lai.' );
						?>
					</p>
						<?php
						if ( ! $theme->parent() ) {
							echo '<p>';
							printf(
								/* translators: %s: Link to documentation on child themes. */
								__( 'Nếu bạn cần điều chỉnh nhiều hơn là CSS của giao diện, bạn có thể thử <a href="%s">tạo một giao diện con</a>.' ),
								esc_url( __( 'https://developer.wordpress.org/themes/advanced-topics/child-themes/' ) )
							);
							echo '</p>';
						}
						?>
					<p><?php _e( 'Nếu bạn quyết định tiếp tục với việc chỉnh sửa trực tiếp, hãy sử dụng trình quản lý tập tin để tạo một bản sao với tên mới và giữ lại bản gốc. Bằng cách đó, bạn có thể kích hoạt lại phiên bản hoạt động nếu có điều gì đó không ổn.' ); ?></p>
				</div>
				<p>
					<a class="button file-editor-warning-go-back" href="<?php echo esc_url( $return_url ); ?>"><?php _e( 'Quay lại' ); ?></a>
					<button type="button" class="file-editor-warning-dismiss button button-primary"><?php _e( 'Tôi hiểu' ); ?></button>
				</p>
			</div>
		</div>
	</div>
	<?php
} // Editor warning notice.

require_once ABSPATH . 'wp-admin/admin-footer.php';
