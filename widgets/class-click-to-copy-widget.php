<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Click to Copy Button widget.
 *
 * Renders a button that copies its text to the clipboard — with an
 * iOS/Safari-safe fallback, since the modern Clipboard API alone isn't
 * reliable there — and can optionally open a link afterward.
 *
 * Every visual property (color, background, border, spacing, typography,
 * icon size) is driven by Elementor controls. The enqueued stylesheet only
 * carries structural/reset rules, so Elementor's own generated CSS is
 * always the final word and style-panel edits show up instantly.
 */
class Click_To_Copy_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'click_to_copy_button';
	}

	public function get_title() {
		return __( 'Click to Copy Button', 'click-to-copy-elementor-widget' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return [ 'codifycore' ];
	}

	public function get_keywords() {
		return [ 'copy', 'clipboard', 'coupon', 'code', 'button', 'promo' ];
	}

	public function get_script_depends() {
		return [ 'ctcew-script' ];
	}

	public function get_style_depends() {
		return [ 'ctcew-style' ];
	}

	protected function register_controls() {

		/* =========================================================
		 * CONTENT TAB
		 * ========================================================= */
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'click-to-copy-elementor-widget' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'code_text',
			[
				'label'       => __( 'Text to Copy', 'click-to-copy-elementor-widget' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'SAVE20',
				'placeholder' => __( 'e.g. SAVE20', 'click-to-copy-elementor-widget' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'copied_text',
			[
				'label'   => __( 'Text After Copying', 'click-to-copy-elementor-widget' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Copied!', 'click-to-copy-elementor-widget' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => __( 'Link', 'click-to-copy-elementor-widget' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => __( 'https://your-link.com', 'click-to-copy-elementor-widget' ),
				'description' => __( 'Optional. If set, the button copies the text above and then opens this link (the "open in new window" option below is respected).', 'click-to-copy-elementor-widget' ),
				'default'     => [
					'url'         => '',
					'is_external' => '',
					'nofollow'    => '',
				],
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label'   => __( 'Icon', 'click-to-copy-elementor-widget' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value'   => 'far fa-copy',
					'library' => 'fa-regular',
				],
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label'     => __( 'Icon Position', 'click-to-copy-elementor-widget' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'before' => [
						'title' => __( 'Before', 'click-to-copy-elementor-widget' ),
						'icon'  => 'eicon-h-align-left',
					],
					'after'  => [
						'title' => __( 'After', 'click-to-copy-elementor-widget' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'before',
				'toggle'    => false,
				'condition' => [ 'selected_icon[value]!' => '' ],
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label'      => __( 'Icon Spacing', 'click-to-copy-elementor-widget' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'condition'  => [ 'selected_icon[value]!' => '' ],
				'selectors'  => [
					'{{WRAPPER}} .ctcew-button' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_id',
			[
				'label'       => __( 'Button ID', 'click-to-copy-elementor-widget' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'description' => __( 'Optional. Make sure the ID is unique and not used elsewhere on the page. Allowed characters: A-Z, 0-9 and underscore, no spaces.', 'click-to-copy-elementor-widget' ),
			]
		);

		$this->end_controls_section();

		/* =========================================================
		 * STYLE TAB
		 * ========================================================= */
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Button', 'click-to-copy-elementor-widget' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'position',
			[
				'label'     => __( 'Position', 'click-to-copy-elementor-widget' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [ 'title' => __( 'Left', 'click-to-copy-elementor-widget' ), 'icon' => 'eicon-h-align-left' ],
					'center'  => [ 'title' => __( 'Center', 'click-to-copy-elementor-widget' ), 'icon' => 'eicon-h-align-center' ],
					'right'   => [ 'title' => __( 'Right', 'click-to-copy-elementor-widget' ), 'icon' => 'eicon-h-align-right' ],
					'stretch' => [ 'title' => __( 'Justified', 'click-to-copy-elementor-widget' ), 'icon' => 'eicon-h-align-stretch' ],
				],
				'default'   => 'left',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'           => 'button_typography',
				'selector'       => '{{WRAPPER}} .ctcew-button',
				'fields_options' => [
					'font_size'   => [ 'default' => [ 'unit' => 'px', 'size' => 14 ] ],
					'font_weight' => [ 'default' => '600' ],
					'line_height' => [ 'default' => [ 'unit' => 'px', 'size' => 17 ] ],
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'button_text_shadow',
				'selector' => '{{WRAPPER}} .ctcew-button',
			]
		);

		$this->start_controls_tabs( 'button_state_tabs' );

		// ---- Normal state ----
		$this->start_controls_tab(
			'button_state_normal',
			[ 'label' => __( 'Normal', 'click-to-copy-elementor-widget' ) ]
		);

		$this->add_control(
			'text_color',
			[
				'label'       => __( 'Text & Icon Color', 'click-to-copy-elementor-widget' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'default'     => '',
				'description' => __( 'Leave empty to inherit your theme\'s default button text color.', 'click-to-copy-elementor-widget' ),
				'selectors'   => [
					'{{WRAPPER}} .ctcew-button'       => 'color: {{VALUE}};',
					'{{WRAPPER}} .ctcew-button__icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'        => 'button_background',
				'types'       => [ 'classic', 'gradient' ],
				'exclude'     => [ 'image' ],
				'selector'    => '{{WRAPPER}} .ctcew-button',
				'description' => __( 'Leave unset to inherit your theme\'s default button background.', 'click-to-copy-elementor-widget' ),
			]
		);

		$this->add_control(
			'border_color',
			[
				'label'       => __( 'Border Color', 'click-to-copy-elementor-widget' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'default'     => '',
				'description' => __( 'Leave empty to inherit your theme\'s default button border color.', 'click-to-copy-elementor-widget' ),
				'selectors'   => [
					'{{WRAPPER}} .ctcew-button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .ctcew-button',
			]
		);

		$this->end_controls_tab();

		// ---- Hover state ----
		$this->start_controls_tab(
			'button_state_hover',
			[ 'label' => __( 'Hover', 'click-to-copy-elementor-widget' ) ]
		);

		$this->add_control(
			'hover_text_color',
			[
				'label'     => __( 'Text & Icon Color', 'click-to-copy-elementor-widget' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ctcew-button:hover'                     => 'color: {{VALUE}};',
					'{{WRAPPER}} .ctcew-button:hover .ctcew-button__icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'button_hover_background',
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' => '{{WRAPPER}} .ctcew-button:hover',
			]
		);

		$this->add_control(
			'hover_border_color',
			[
				'label'     => __( 'Border Color', 'click-to-copy-elementor-widget' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ctcew-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_transition',
			[
				'label'      => __( 'Transition Duration', 'click-to-copy-elementor-widget' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 's' ],
				'range'      => [ 's' => [ 'min' => 0, 'max' => 3, 'step' => 0.1 ] ],
				'default'    => [ 'unit' => 's', 'size' => 0.3 ],
				'selectors'  => [
					'{{WRAPPER}} .ctcew-button' => 'transition-duration: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} .ctcew-button:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'border_style',
			[
				'label'     => __( 'Border Type', 'click-to-copy-elementor-widget' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => [
					'none'   => __( 'None', 'click-to-copy-elementor-widget' ),
					'solid'  => __( 'Solid', 'click-to-copy-elementor-widget' ),
					'double' => __( 'Double', 'click-to-copy-elementor-widget' ),
					'dotted' => __( 'Dotted', 'click-to-copy-elementor-widget' ),
					'dashed' => __( 'Dashed', 'click-to-copy-elementor-widget' ),
					'groove' => __( 'Groove', 'click-to-copy-elementor-widget' ),
				],
				'selectors' => [
					'{{WRAPPER}} .ctcew-button' => 'border-style: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_width',
			[
				'label'      => __( 'Border Width', 'click-to-copy-elementor-widget' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 1 ],
				'condition'  => [ 'border_style!' => 'none' ],
				'selectors'  => [
					'{{WRAPPER}} .ctcew-button' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'click-to-copy-elementor-widget' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '12',
					'right'    => '12',
					'bottom'   => '12',
					'left'     => '12',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .ctcew-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => __( 'Icon Size', 'click-to-copy-elementor-widget' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'condition'  => [ 'selected_icon[value]!' => '' ],
				'selectors'  => [
					'{{WRAPPER}} .ctcew-button__icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}}; line-height: 1;',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => __( 'Padding', 'click-to-copy-elementor-widget' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'      => '12',
					'right'    => '18',
					'bottom'   => '12',
					'left'     => '18',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .ctcew-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Build up the button's HTML attributes through Elementor's own
	 * render-attribute API rather than concatenating strings by hand.
	 * This keeps escaping consistent with core Elementor widgets and
	 * plays nicely with dynamic tags.
	 */
	private function set_button_attributes( array $settings ) {
		$code    = $settings['code_text'];
		$stretch = ( 'stretch' === $settings['position'] );

		$this->add_render_attribute( 'button', 'type', 'button' );
		$this->add_render_attribute( 'button', 'class', 'ctcew-button' );
		if ( $stretch ) {
			$this->add_render_attribute( 'button', 'class', 'ctcew-button--full-width' );
		}

		$this->add_render_attribute( 'button', 'data-code', $code );
		$this->add_render_attribute( 'button', 'data-copied-text', $settings['copied_text'] );

		// A real accessible label, so screen readers announce the actual action.
		$this->add_render_attribute(
			'button',
			'aria-label',
			sprintf(
				/* translators: %s: the text or code that will be copied */
				__( 'Copy %s to clipboard', 'click-to-copy-elementor-widget' ),
				$code
			)
		);

		if ( ! empty( $settings['button_id'] ) ) {
			$safe_id = preg_replace( '/[^A-Za-z0-9_]/', '', $settings['button_id'] );
			if ( $safe_id ) {
				$this->add_render_attribute( 'button', 'id', $safe_id );
			}
		}

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'button', 'data-href', $settings['link']['url'] );
			$this->add_render_attribute(
				'button',
				'data-target',
				! empty( $settings['link']['is_external'] ) ? '_blank' : '_self'
			);
		}
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$has_icon = ! empty( $settings['selected_icon']['value'] );
		$icon_pos = ! empty( $settings['icon_position'] ) ? $settings['icon_position'] : 'before';

		$this->set_button_attributes( $settings );

		$this->add_render_attribute( 'text', 'class', 'ctcew-button__text' );
		$this->add_render_attribute( 'text', 'aria-live', 'polite' ); // Announce "Copied!" to screen readers.
		?>
		<button <?php $this->print_render_attribute_string( 'button' ); ?>>
			<?php if ( $has_icon && 'before' === $icon_pos ) : ?>
				<?php \Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true', 'class' => 'ctcew-button__icon' ] ); ?>
			<?php endif; ?>

			<span <?php $this->print_render_attribute_string( 'text' ); ?>><?php echo esc_html( $settings['code_text'] ); ?></span>

			<?php if ( $has_icon && 'after' === $icon_pos ) : ?>
				<?php \Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true', 'class' => 'ctcew-button__icon' ] ); ?>
			<?php endif; ?>
		</button>
		<?php
	}
}
