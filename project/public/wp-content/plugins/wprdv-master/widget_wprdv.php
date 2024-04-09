<?php




	/* listeProduitsLeft */
class wp_produitslem_plugin extends WP_Widget {

	// constructor
	public function __construct() {
		/* ... */
		parent::WP_Widget(false, $name = __('Liste produits (Colonne gauche)', 'wp_produitslem_plugin') );
	}

	// widget form creation
	function form($instance) {	
	/* ... */
	}

	// widget update
	function update($new_instance, $old_instance) {
		/* ... */
	}

	// widget display
	function widget($args, $instance) {
		
		
		//// extraction de la liste des produits classés par categories
		//////
		global $wp_query;
		$post_obj = $wp_query->get_queried_object();
		$Page_ID = $post_obj->ID;

		$datas = extractListeCatesFromPost($Page_ID);
		
		$html = "";
		$indexCate = 0;
		foreach(  $datas as $value ){
			
			$libelle_cate = str_replace("<br>", " " , $value->cates_libelle );
			
			$html.="<ul><span class='cateNameLeft'  onClick='javascript:showBlockProduitFromLeft( \"cate_".$value->cates_id."\");' >".$libelle_cate."</span>";
			
				//// extraction de la liste des produits de la categorie en question
				$prodliste = extractProduitFromCate($value->cates_id);
				foreach($prodliste as $prod){
					
					$html.= "<li onClick='javascript:showBlockProduitFromLeft( \"cate_".$value->cates_id."\");' >> ".$prod->prod_libelle."</li>";	
				}
			$html.="</ul>";
			$indexCate++;
		}
		
		echo $html;		
					
					
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("wp_produitslem_plugin");'));









?>