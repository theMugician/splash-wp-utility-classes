<?php
if ( ! class_exists( 'Splash_Fields' ) ) {

	class Splash_Fields {

		/**
		 * Get default options for field
		 * @param  string $id               Field Meta Key
		 * 
		 * @return array {
		 *      @type string name           Input's name attribute
		 *      @type string value          Input's value attribute
		 *      @type string description    Description for field usage
		 * } 
		 */   
		public function get_default_options($id) {
			return array(
				'name' => $id,
				'value' => esc_attr( get_post_meta( get_the_ID(), $id, true )),
				'description' => '',
			);
		}
		
		/**
		 * Render text field
		 * @param  string $id
		 * @param  string $title
		 * @param  array  $options 
		 * @see	   		  get_default_options()
		 * 
		 * @return void    
		 */
		public function text( $id, $title, $options = null ) { 
			if (!$options) $options = $this->get_default_options($id);
		?>
		<div class="splash-field">
			<div class="splash-field__title">
				<label class="splash-field__label" for="<?php echo $id; ?>"><?php echo $title; ?></label>
			</div>
			<div class="splash-field__field-set">
				<input
					class="splash-field__input"
					type="text"
					name="<?php echo $options['name']; ?>" 
					id="<?php echo $id; ?>" 
					value="<?php echo $options['value']; ?>" 
					/>	
				<?php 
				if( $options['description'] != '' ) {
					echo '<p class="splash-field__description">' . $options['description'] . '</p>';
				}
				?>
			</div>
		</div>
		<?php
		}

		/**
		 * Render radio button group
		 * 
		 * @param  string $id
		 * @param  string $title
		 * @param  array  $options
		 *      @type string name           Input's name attribute
		 *      @type string value          Input's value attribute
		 *      @type string description    Description for field usage 
		 *      @type array  radio_buttons
		 *      	@type string id           	Radio Button's id attribute
		 *      	@type string title          Radio Button's title
		 *      	@type string name           Radio Button's name attribute
		 *      	@type string value          Radio Button's value attribute     
		 * @return void     
		 */  
		public function radio( $id, $title, $options = null ) { 
			if (!$options) $options = $this->get_default_options($id);
			?>
			<div class="splash-field">
				<div class="splash-field__title">
					<p class="splash-field__label"><?php echo $title; ?></p>
				</div>
				<div class="splash-field__field-set">
					<div class="splash-field__radio-group">
					<?php
						foreach ($options['radio_buttons'] as $radio_button) {
							echo '<label for="' . $radio_button['id'] . '">' . $radio_button['title'] . '</label>';
							echo '<input class="splash-field__radio-button" name="' . $options['name'] . '" id="' . $radio_button['id'] . '" type="radio" ' . checked( $options['value'], $radio_button['value'], false ) . ' value="' . $radio_button['value'] . '">';
						}
					?>	
					</div>
					<?php if( $options['description'] != '' ) {
						echo '<p class="splash-field__description">' . $options['description'] . '</p>';
					}?>
				</div>
			</div>
			<?php
		}

		/**
		 * Render checkbox field
		 * @param  string $id
		 * @param  string $title
		 * @param  array  $options 
		 *      @type string name           Input's name attribute
		 *      @type string value          *Required custom value attribute
		 *      @type string description    Description for field usage 	 
		 * 
		 * @return void    
		 */
		public function checkbox( $id, $title, $options = null ) { 
			if (!$options) $options = $this->get_default_options($id);
			$meta_key_value = esc_attr( get_post_meta( get_the_ID(), $id, true ));
			?>
			<div class="splash-field">
				<div class="splash-field__title">
					<label class="splash-field__label" for="<?php echo $id; ?>"><?php echo $title; ?></label>
				</div>
				<div class="splash-field__field-set">
					<?php 
					// var_dump($options); 
					var_dump($meta_key_value);
					?>
					<input 
						class="splash-field__checkbox"
						type="checkbox" 
						name="<?php echo $options['name']; ?>"
						value="1"
						id="<?php echo $id; ?>"
						<?php checked( $meta_key_value, 1 ); ?>
					/>	
				<?php 
				if( $options['description'] != '' ) {
					echo '<p class="splash-field__description">' . $options['description'] . '</p>';
				}
				?>
				</div>
			</div>
			<?php
		}
	}
}