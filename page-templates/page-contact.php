<?php
/**
 * Template Name: Contact
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 1.0
 */

get_header();

?>
	<div id="wrap" class="container clearfix">

		<section id="content" class="primary" role="main">

			<h2 class="page-title entry-title"><?php the_title(); ?></h2>

			<form id="form-contact" action="" method="POST" enctype="multipart/form-data">

				<?php
				global $meta_boxes;

				$debug = '<pre>'.print_r($_POST, true).'</pre>';
				$debug .= '<pre>'.print_r($_FILES, true).'</pre>';

				$submitted = !empty($_POST);

				$prefix = 'contact';
				$meta_boxes = starter_meta_boxes($meta_boxes);
				$fields = $meta_boxes[$prefix];

				$errors = array();

				$form = '';
				foreach($fields['fields'] as $field) {

					$id = !empty($field['id']) ? $field['id'] : '';
					$name = $field['name'];
					$type = $field['type'];
					$size = (int) @$field['size'];
					$value = !empty($id) && !empty($_POST[$id]) ? $_POST[$id] : '';
					$required = (bool) @$field['required'];
					$format = @$field['format'];
					$error = !empty($field['error']) ? $field['error'] : '';
					$desc = @$field['desc'];

					if ($submitted) {
						if (empty($value)) {
							if ($required) {
								$errors[$id] = $error ?:'Vous devez renseigner le champ `'.$name.'`';
							}
						} else {

							if ($type == 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
								$errors[$id] = $error ?:__('Vous devez renseigner un email valide', 'starter');
							}
							if (!empty($format) && !preg_match($format, $value)) {
								$errors[$id] = $error ?:__('Vous devez renseigner un format valide', 'starter');
							}
						}
					}

					switch ($type) {
						case 'heading':
							$form .= '<h1>'.$name.'</h1>'.PHP_EOL;
						break;
						case 'text':
						case 'email':
						case 'wysiwyg':
						case 'checkbox_list':
						case 'radio':
						case 'file_advanced':

							$form .= '<div class="form-group'.(!empty($errors[$id]) ? ' error' : '').'">'.PHP_EOL;
							$form .= '<label for="'.$id.'">'.$name.'</label>';

							if (!empty($desc)) {
								$form .= '<div class="info">'.$desc.'</div>'.PHP_EOL;
							}

							if ($type == 'wysiwyg') {
								$form .= '<textarea id="'.$id.'" name="'.$id.'" class="wysiwyg">'.$value.'</textarea>'.PHP_EOL;
							} else if ($type == 'checkbox_list') {
								foreach($field['options'] as $option_value => $option_label) {
									$form .= '<input id="'.$id.'_'.$option_value.'" name="'.$id.'[]" type="checkbox" value="'.$option_value.'" '.(!empty($_POST[$id]) && in_array($option_value, $_POST[$id]) ? 'checked="checked"' : '').'> '.$option_label.'<br>'.PHP_EOL;
								}
							} else if ($type == 'radio') {
								foreach($field['options'] as $option_value => $option_label) {
									$form .= '<input id="'.$id.'_'.$option_value.'" name="'.$id.'" type="radio" value="'.$option_value.'" '.($value == $option_value ? 'checked="checked"' : '').'> '.$option_label.PHP_EOL;
								}
							} else if ($type == 'file_advanced') {

								//$form .= '<input type="file" name="attachments[]">'.PHP_EOL;

								$form .= '<button id="uploadButton" class="btn btn-large btn-primary">Choisir un fichier</button>'.PHP_EOL;
								/*$form .= '<div id="progressOuter" class="progress progress-striped active" style="display:none;"></div>'.PHP_EOL;
								$form .= '<div id="progressBar" class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>'.PHP_EOL;
								*/
								$form .= '<div id="progressBox"></div>';
								$form .= '<ul id="msgBox"></ul>'.PHP_EOL;

								/*
								$form .= '<div id="progressBox">'.PHP_EOL;
								$form .= '	<div class="wrapper">'.PHP_EOL;
								$form .= '		<div class="name">Fiche fournisseur.docx</div>'.PHP_EOL;
								$form .= '		<div class="size">103K</div>'.PHP_EOL;
								$form .= '		<div class="progress">'.PHP_EOL;
								$form .= '			<div class="bar" style="width: 93%;"></div>'.PHP_EOL;
								$form .= '		</div>'.PHP_EOL;
								$form .= '	</div>'.PHP_EOL;
								$form .= '</div>'.PHP_EOL;
								*/

							} else {
								$form .= '<input id="'.$id.'" name="'.$id.'" type="text" '.($size ? 'size="'.$size.'"' : '').' value="'.$value.'">'.PHP_EOL;
							}

							if (!empty($errors[$id])) {
								$form .= '<div class="error">'.$errors[$id].'</div>'.PHP_EOL;
							}

							$form .= '</div>'.PHP_EOL;

						break;
					}

					//echo print_r($field).'<br><br>';
				}

				if ($submitted && empty($errors)) {

					$contact = array(
						'post_title'    => 'Contact '.$_POST['contact_prenom'].' '.$_POST['contact_nom'].' - '.date('d-m-Y H:i:s'),
						'post_status'   => 'private',
						'post_author'   => 1,
						'post_type' 	=> 'contact'
					);

					//$post_id = 42;
					$post_id = wp_insert_post($contact);

					if (empty($post_id)) {
						exit('Error');
					}

					foreach($fields['fields'] as $field) {

						if ($field['type'] == 'heading') {
							continue;
						}

						$meta_key = $field['id'];
						$meta_value = !empty($_POST[$meta_key]) ? $_POST[$meta_key] : '';

						if (!is_array($meta_value)) {
							$debug .= "update_post_meta($post_id, $meta_key, $meta_value);<br>";
							update_post_meta($post_id, $meta_key, $meta_value);
						} else {
							$debug .= "delete_post_meta($post_id, $meta_key);<br>";
							delete_post_meta($post_id, $meta_key);
							foreach($meta_value as $key => $meta_value) {
								$debug .= "add_post_meta($post_id, $meta_key, $meta_value);<br>";
								add_post_meta($post_id, $meta_key, $meta_value);
							}
						}
					}

					echo '<div class="success">Votre message a bien été enregistré<br>Vous allez être redirigé(e) dans 3 secondes...</div>';
					echo '<script>setTimeout(function() { window.location.href = "'.home_url().'"; }, 3000);</script>';
					goto end;
				}

				//echo $debug;

				if (!empty($errors)) {
					echo '<div class="errors">'.__('Le formulaire comporte des erreurs', 'starter').'</div>';
				}

				echo $form;
				?>

				<br><br>

				<button type="submit" class="btn btn-blue"><?= __('Send', 'starter') ?></button>

				<?php end: ?>

			</form>

		</section>

	</div>

<?php get_footer(); ?>