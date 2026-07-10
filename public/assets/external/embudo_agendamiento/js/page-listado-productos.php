<?php
	/*
	Template Name: Pagina Listado Productos
	*/
	
	global $post;

	//$proveedoresAutorizados = ['Agritop','Agrobiomaz','Aquagrow','Cargill','Chemcrop','Créditos Económicos','Eurofert','Ecuaquímica','Farmagro','Ferpacific','Importadora Alaska','Inducampo','Lubrival','Motrac','Plastiempaques','Quimiser','Skretting','Tecnoindustry'];
	$proveedoresAutorizados = explode(',',get_field('proveedores'));
	$catalogo = get_field('catalogo');
	$stock = get_field('stock');

	if($catalogo == "No"){
		$params = array(
	   		'status' 	 	 => 'publish',
	        'posts_per_page' => -1,
	        'post__not_in' 	 => array(9144,9145),
	        'post_type'		 => 'product',
	        'orderby' 		 => 'title',
	      	'order' 		 => 'ASC',
	      	'tax_query'   	 => array( array(
		        'taxonomy'   => 'product_visibility',
		        'terms'      => array( 'exclude-from-catalog' ),
		        'field'      => 'name',
		        'operator'   => 'NOT IN'
		    ) )
		);
	}else{
		$params = array(
	   		'status' 	 	 => 'publish',
	        'posts_per_page' => -1,
	        'post__not_in' 	 => array(9144,9145),
	        'post_type'		 => 'product',
	        'orderby' 		 => 'title',
	      	'order' 		 => 'ASC'
		);
	}

	$myproducts = new WP_Query($params);
?>
	<table border="1" width="100%">
		<thead>
			<tr>
				<th>Cantidad</th>
				<th>Post ID</th>
				<th>SKU</th>
				<th>title</th>
				<th>description</th>
				<th>availability</th>
				<th>condition</th>
				<th>price</th>
				<th>sale_price</th>
				<!--th>price reg</th>
				<th>price venta</th-->
				<th>link</th>
				<th>image_link</th>
				<th>brand</th>
				<th>google_product_category</th>
				<th>product_type</th>
			</tr>
		</thead>
		<tbody>
<?php
	
	function get_product_subcategories_list( $category_slug ){
	    $terms_html = array();
	    $taxonomy = 'product_cat';
	    // Get the product category (parent) WP_Term object
	    $parent = get_term_by( 'slug', $category_slug, $taxonomy );
	    // Get an array of the subcategories IDs (children IDs)
	    $children_ids = get_term_children( $parent->term_id, $taxonomy );

	    // Loop through each children IDs
	    foreach($children_ids as $children_id){
	        $term = get_term( $children_id, $taxonomy ); // WP_Term object
	        $term_link = get_term_link( $term, $taxonomy ); // The term link
	        if ( is_wp_error( $term_link ) ) $term_link = '';
	        // Set in an array the html formated subcategory name/link
	        $terms_html[] = '<a href="' . esc_url( $term_link ) . '" rel="tag" class="' . $term->slug . '">' . $term->name . '</a>';
	    }
	    return '<span class="subcategories-' . $category_slug . '">' . implode( ', ', $terms_html ) . '</span>';
	}
	$contador = 0;

	while($myproducts->have_posts()) : 
	    $myproducts->the_post();
	    $postId = get_the_ID();
	    $urlProduct = get_permalink( $postId );
		$product = wc_get_product( $postId );

		$precio_regular = $product->get_regular_price();
		$precio_venta = $product->get_sale_price();
		$precio = $product->get_price();
		//$descripcion = $product->get_short_description();
		$descripcion_orig = $product->get_description();
		$descripcion = strip_tags($descripcion_orig );

		$sku = $product->get_sku();

		$cantidad = $product->get_stock_quantity();

		$image_id  = $product->get_image_id();
		$image_url = wp_get_attachment_image_url( $image_id, 'full' );
		$proveedor = get_field('proveedor');

		$productId = $product->get_id();
		$productCategories = strip_tags($product->get_categories());

		//$precioWoo = get_post_meta( get_the_ID(), '_regular_price', true);

		/*$productCategories = explode(',',strip_tags($product->get_categories()));

		var_dump($productCategories[0]);
		$parentcats = get_ancestors($product_cat_id, 'product_cat');

		echo get_product_subcategories_list( $productCategories[0] );

		if( $term = get_term_by( 'id', $postId, 'product_cat' ) ){
		    echo $term->name;
		}

		die();*/

		/*$pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
		$replacement = "";
		preg_replace($pattern, $replacement, $descripcion);*/

		if($stock == "No"){
			$min = 0;
		}else{
			$min = -1;
		}

		if($cantidad > $min && in_array($proveedor, $proveedoresAutorizados)){
			$contador++;

?>
			<tr>
				<td><?php echo $contador; ?></td>
				<td><?php echo $postId; ?></td>
				<td><?php echo $sku; ?></td>
				<td><?php the_title(); ?></td>
				<td><?php echo $descripcion; ?></td>
				<td>in stock</td>
				<td>new</td>
				<td><?php echo $precio_regular; ?></td>
				<!--td><?php echo $precio_venta; ?></td-->
				<td>
					<?php
						if(!empty($precio_venta)){
							if($precio_venta < $precio_regular){
								echo $precio_venta;
							}else{
								echo $precio_regular;
							}
						}else{
							echo $precio_regular;
						}
					?>
				</td>
				<!--td><?php echo $precioWoo; ?></td>
				<td><?php echo $precio_venta; ?></td-->
				<td><?php echo $urlProduct; ?></td>
				<td><?php echo $image_url; ?></td>
				<td><?php echo $proveedor; ?></td>
				<td>Business & Industrial > Agriculture</td>
				<td><?php echo $productCategories; ?></td>
			</tr>

<?php
		}
	endwhile; 
?>
		</tbody>
	</table>
	<style type="text/css">
		table, th, td {
		  border: 1px solid black;
		  border-collapse: collapse;
		}
	</style>