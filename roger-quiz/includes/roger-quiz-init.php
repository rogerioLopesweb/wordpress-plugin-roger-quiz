<?php
/*Inicio Cria o CPT  personalisado*/
function cria_post_type_roger_quiz() {
    $supports = array(
    'title', // post title
    'editor', // post content
    'author', // post author
    'thumbnail', // featured images
    'excerpt', // post excerpt
    //'custom-fields', // custom fields
    //'comments', // post comments
    'revisions', // post revisions
    'post-formats', // post formats
    );
    $labels = array(
    'name' => _x('Roger Quiz', 'plural'),
    'singular_name' => _x('Roger Quiz', 'singular'),
    'menu_name' => _x('Roger Quiz', 'admin menu'),
    'name_admin_bar' => _x('roger-quiz', 'admin bar'),
    'add_new' => _x('Add Quiz', 'add quiz'),
    'add_new_item' => __('Add Quiz'),
    'new_item' => __('Novo quiz'),
    'edit_item' => __('Editar quiz'),
    'view_item' => __('Ver quiz'),
    'all_items' => __('Todos quiz'),
    'search_items' => __('Buscar quiz'),
    'not_found' => __('Nenhum quiz.'),
    );
    $args = array(
    'supports' => $supports,
    'labels' => $labels,
    'public' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'roger-quiz'),
    'has_archive' => true,
    'hierarchical' => false,
    );
    register_post_type('roger-quiz', $args);
    }
    add_action('init', 'cria_post_type_roger_quiz');
    
  /*Inicio Cria o CPT  personalisado*/

  /*Inicio Cria o CPT  personalisado*/
function cria_post_type_roger_quiz_perguntas() {
  $supports = array(
  'title', // post title
  //'editor', // post content
  'author', // post author
  //'thumbnail', // featured images
  //'excerpt', // post excerpt
  //'custom-fields', // custom fields
  //'comments', // post comments
  'revisions', // post revisions
  'post-formats', // post formats
  );
  $labels = array(
  'name' => _x('Roger Quiz Perguntas', 'plural'),
  'singular_name' => _x('Roger Quiz Perguntas', 'singular'),
  'menu_name' => _x('Roger Quiz Perguntas', 'admin menu'),
  'name_admin_bar' => _x('roger-quiz-perguntas', 'admin bar'),
  'add_new' => _x('Add Perguntas', 'add Perguntas'),
  'add_new_item' => __('Add Perguntas'),
  'new_item' => __('Nova Perguntas'),
  'edit_item' => __('Editar perguntas'),
  'view_item' => __('Ver Perguntas'),
  'all_items' => __('Todos Perguntas'),
  'search_items' => __('Buscar Perguntas'),
  'not_found' => __('Nenhum Perguntas.'),
  );
  $args = array(
  'supports' => $supports,
  'labels' => $labels,
  'public' => true,
  'query_var' => true,
  'rewrite' => array('slug' => 'roger-quiz-perguntas'),
  'has_archive' => false,
  'hierarchical' => true,
  );
  register_post_type('roger-quiz-perguntas', $args);
  }
  add_action('init', 'cria_post_type_roger_quiz_perguntas');
  
/*Inicio Cria o CPT  personalisado*/

function roger_quiz_meta_box() {
  add_meta_box(
      'quiz-currente',
      __( 'Quiz', 'sitepoint' ),
      'roger_quiz_meta_box_callback',
      'roger-quiz-perguntas'
  );
}

add_action( 'add_meta_boxes', 'roger_quiz_meta_box' );
function roger_quiz_meta_box_callback(){

  $idquiz = esc_attr( get_post_meta( get_the_ID(), 'quiz-id', true ) );
  $posts = get_posts(array (
    'numberposts' => -1,   // -1 returns all posts
    'post_type' => 'roger-quiz',
    'orderby' => 'title',
    'order' => 'ASC'
  ));
  echo '<select name="quiz-id" required="" id="quiz-post-id" placeholder="Quiz">';    
	foreach ($posts as $post):
    if($idquiz == $post->ID){
      echo '<option value="'.$post->ID.'" selected >'.$post->ID.'-'.$post->post_title.'</option>';
    }else{
      echo '<option value="'.$post->ID.'">'.$post->ID.'-'.$post->post_title.'</option>';  
    } 
    
  endforeach;
  echo '</select>';
}
function save_roger_quiz_meta_box_callback( $post_id ) {

	if ( ! isset( $_POST['quiz-id'] ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['post_type'] ) && 'page' === $_POST['post_type'] ) {

		// do stuff

	}
	// Check if $_POST field(s) are available
	// Sanitize
	// Save
  update_post_meta( $post_id, 'quiz-id', sanitize_text_field( $_POST['quiz-id'] ) );
}
add_action( 'save_post', 'save_roger_quiz_meta_box_callback' );



/* Metabox Resposta */
function roger_quiz_resposta_meta_box() {
  add_meta_box(
      'quiz-respostas',
      __( 'Respostas', 'sitepointa' ),
      'roger_quiz_respostas_meta_box_callback',
      'roger-quiz-perguntas'
  );
}
add_action( 'add_meta_boxes', 'roger_quiz_resposta_meta_box' );
function roger_quiz_respostas_meta_box_callback(){
  $idquiz = esc_attr( get_post_meta( get_the_ID(), 'quiz-id', true ) );
  $quiz_resposta_a = esc_attr( get_post_meta( get_the_ID(), 'roger-quiz-resp-a', true ) );
  $quiz_resposta_b = esc_attr( get_post_meta( get_the_ID(), 'roger-quiz-resp-b', true ) );
  $quiz_resposta_c = esc_attr( get_post_meta( get_the_ID(), 'roger-quiz-resp-c', true ) );
  $quiz_resposta_d = esc_attr( get_post_meta( get_the_ID(), 'roger-quiz-resp-d', true ) );
  $quiz_resposta_e = esc_attr( get_post_meta( get_the_ID(), 'roger-quiz-resp-e', true ) );
  $quiz_resposta_certa = esc_attr( get_post_meta( get_the_ID(), 'roger-quiz-resp-certa', true ) );
  echo '<label for="quiz_resp_a">'. esc_html('A )','text-domain').'</label> ';
	echo '<input type="text" class="regular-text" name="quiz_resp_a" id="quiz_resp_a" value="'.$quiz_resposta_a.'" required>';
  echo  "<br><br>";
  echo '<label for="quiz_resp_b">'. esc_html('B )','text-domain').'</label> ';
	echo '<input type="text" class="regular-text" name="quiz_resp_b" id="quiz_resp_b" value="'.$quiz_resposta_b.'" required>';
  echo  "<br><br>";
  echo '<label for="quiz_resp_c">'. esc_html('C )','text-domain').'</label> ';
	echo '<input type="text" class="regular-text" name="quiz_resp_c" id="quiz_resp_c" value="'.$quiz_resposta_c.'" required>';
  echo  "<br><br>";
  echo '<label for="quiz_resp_d">'. esc_html('D )','text-domain').'</label> ';
	echo '<input type="text" class="regular-text" name="quiz_resp_d" id="quiz_resp_d" value="'.$quiz_resposta_d.'" required>';
  echo  "<br><br>";
  echo '<label for="quiz_resp_e">'. esc_html('E )','text-domain').'</label> ';
	echo '<input type="text" class="regular-text" name="quiz_resp_e" id="quiz_resp_e" value="'.$quiz_resposta_e.'" required>';
  echo  "<br><br>";
  echo  "Informe a resposta correta<br>";
  echo '<select name="quiz_resp_certa" required id="quiz-resp-certa">';  
  
  if($quiz_resposta_certa == "A"){
    echo '<option value="A" selected>A</option>';
  }else{
    echo '<option value="A">A</option>';
  } 
  if($quiz_resposta_certa == "B"){
    echo '<option value="B" selected>B</option>';
  }else{
    echo '<option value="B">B</option>';
  } 
  if($quiz_resposta_certa == "C"){
    echo '<option value="C" selected>C</option>';
  }else{
    echo '<option value="C">C</option>';
  } 
  if($quiz_resposta_certa == "D"){
    echo '<option value="D" selected>D</option>';
  }else{
    echo '<option value="D">D</option>';
  } 
  if($quiz_resposta_certa == "E"){
    echo '<option value="E" selected>A</option>';
  }else{
    echo '<option value="E">E</option>';
  } 
  echo '</select>';
}

function save_roger_quiz_meta_box_respostas_callback( $post_id ) {

	if ( ! isset( $_POST['quiz_resp_a'] ) ) {
		return;
	}
  if ( ! isset( $_POST['quiz_resp_b'] ) ) {
		return;
	}
  if ( ! isset( $_POST['quiz_resp_c'] ) ) {
		return;
	}
  if ( ! isset( $_POST['quiz_resp_d'] ) ) {
		return;
	}
  if ( ! isset( $_POST['quiz_resp_e'] ) ) {
		return;
	}
  if ( ! isset( $_POST['quiz_resp_certa'] ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['post_type'] ) && 'page' === $_POST['post_type'] ) {

		// do stuff

	}
	// Check if $_POST field(s) are available
	// Sanitize
	// Save 

  update_post_meta( $post_id, 'roger-quiz-resp-a', sanitize_text_field( $_POST['quiz_resp_a'] ) );
  update_post_meta( $post_id, 'roger-quiz-resp-b', sanitize_text_field( $_POST['quiz_resp_b'] ) );
  update_post_meta( $post_id, 'roger-quiz-resp-c', sanitize_text_field( $_POST['quiz_resp_c'] ) );
  update_post_meta( $post_id, 'roger-quiz-resp-d', sanitize_text_field( $_POST['quiz_resp_d'] ) );
  update_post_meta( $post_id, 'roger-quiz-resp-e', sanitize_text_field( $_POST['quiz_resp_e'] ) );
  update_post_meta( $post_id, 'roger-quiz-resp-certa', sanitize_text_field( $_POST['quiz_resp_certa'] ) );
}
add_action( 'save_post', 'save_roger_quiz_meta_box_respostas_callback' );

