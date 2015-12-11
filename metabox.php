<?php

add_filter( 'rwmb_meta_boxes', 'starter_meta_boxes' );

function starter_meta_boxes($meta_boxes) {

	include_once 'inc/countries.php';

	$post_id = !empty($_GET['post']) ? $_GET['post'] : @$_POST['post_ID'];

	$template_file = '';
	if (!empty($post_id)) {
		$template_file = get_post_meta($post_id, '_wp_page_template', true);
	}

	$prefix = 'contact_';

	$meta_boxes['contact'] = array(
		'id' => 'contact',
		'title' => 'Contacts',
		'pages' => array('contact'),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(

			// Coordonnées
			array(
				'name' => __('Coordonnées', 'starter'),
				'type' => 'heading',
			),
			array(
				'name' => __('Civilité', 'starter'),
				'id' => $prefix.'civility',
				'type' => 'radio',
				'options' => array(
					'madame' => __('Madame', 'starter'),
					'monsieur' => __('Monsieur', 'starter')
				)
			),
			array(
				'name' => __('Prénom', 'starter'),
				'id' => $prefix.'firstname',
				'type' => 'text',
				'size' => 50,
				'required' => true,
				'error' => __('Vous devez renseigner votre prénom', 'starter')
			),
			array(
				'name' => __('Nom', 'starter'),
				'id' => $prefix.'lastname',
				'type' => 'text',
				'size' => 50,
				'required' => true,
				'error' => __('Vous devez renseigner votre nom', 'starter')
			),
			array(
				'name' => __('Email', 'starter'),
				'id' => $prefix.'email',
				'type' => 'email',
				'desc' => '',
				'size' => 50,
				'required' => true,
				'error' => __('Vous devez renseigner un email valide', 'starter')
			),
			array(
				'name' => __('Pays', 'starter'),
				'id' => $prefix.'country',
				'type' => 'select_advanced',
				'options' => $countries
			),

			// Message
			array(
				'name' => __('Message', 'starter'),
				'type' => 'heading',
			),

			array(
				'name' => __('Sujet', 'starter'),
				'id' => $prefix.'subject',
				'type' => 'checkbox_list',
				'options' => array(
					'renseignements' => __('Demande de renseignements', 'starter'),
					'devis' => __('Demande de devis', 'starter'),
					'bug' => __('Signaler un bug', 'starter'),
					'autre' => __('Autre', 'starter')
			    ),
				'related_field' => array('motivation5', $prefix.'autres_motivations')
			),
			array(
				'name' => __('Message', 'starter'),
				'id' => $prefix.'message',
				'type' => 'wysiwyg',
				'desc' => '',
				'required' => true,
				'error' => __('Votre message ne doit pas être vide', 'starter')
			),
		)
	);

	/*
	$prefix = 'option_';

	$meta_boxes['option'] = array(
		'id' => 'option',
		'title' => 'Options',
		'pages' => array('page'),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(

			// Encarts
			array(
				'name' => __('Encarts', 'starter'),
				'type' => 'heading',
			),
			array(
				'name' => __('Contenu', 'starter'),
				'id' => $prefix.'blocks_content',
				'type' => 'wysiwyg'
			),

			// Sidebar
			array(
				'name' => __('Sidebar', 'starter'),
				'type' => 'heading',
			),
			array(
				'name' => __('Contenu', 'starter'),
				'id' => $prefix.'sidebar_content',
				'type' => 'wysiwyg'
			),


			// Slideshow
			array(
				'name' => __('Slideshow', 'starter'),
				'type' => 'heading',
			),
			array(
				'name' => __('Slider ID', 'starter'),
				'id' => $prefix.'slider_id',
				'type' => 'text'
			),
		)
	);
	*/

	return $meta_boxes;
}