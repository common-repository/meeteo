<?php

namespace Meeteo\WPApi\Shortcodes;
class Meeteo_Embed
{
    /**
     * Instance
     * @var null
     */
    private static $_instance = null;

    public static function get_instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function embed_widget($attributes)
    {
        $error_message = 'Please provide valid URL.';
        if (empty($attributes) || empty($attributes['url'])) {
            return $error_message;
        }
        $refined_attributes = $this->refine_attributes($attributes);
        $this->refine_attributes([]);
        switch ($refined_attributes['embed_type']) {
            case MEETEO_INLINE_EMBED:
                return $this->embed_inline($refined_attributes);
            case MEETEO_INLINE_LINK_EMBED:
                return $this->embed_inline_link($refined_attributes);
            case MEETEO_POPUP_TEXT_EMBED:
                return $this->embed_popup_text($refined_attributes);
            case MEETEO_POPUP_WIDGET_EMBED:
                return $this->embed_popup_widget($refined_attributes);
            default:
                return $this->embed_inline($refined_attributes);
        }
    }

    public function refine_attributes($attributes)
    {
        $atts = shortcode_atts(
            [
                'type' => '',
                'url' => '',
                'text' => '',
                'style_class' => '',
                'text_color' => '',
                'button_color' => '',
                'iframe_width' => '',
                'iframe_height' => '',
            ], $attributes);
        $url = ($atts['url']);
        $embed_type = (!empty($atts['type'])) ? sanitize_text_field($atts['type']) : MEETEO_INLINE_EMBED;
        $text = (!empty($atts['text'])) ? sanitize_text_field($atts['text']) : 'Book webinars and services';
        $class = (!empty($atts['class'])) ? sanitize_text_field($atts['class']) : '';
        $text_color = (!empty($atts['text_color'])) ? sanitize_text_field($atts['text_color']) : '#ffffff';
        $button_color = (!empty($atts['button_color'])) ? sanitize_text_field($atts['button_color']) : '#00a2ff';
        $iframe_width = (!empty($atts['iframe_width'])) ? sanitize_text_field($atts['iframe_width']) : '320px';
        $iframe_height = (!empty($atts['iframe_height'])) ? sanitize_text_field($atts['iframe_height']) : '600px';
        $refined_attributes = ['embed_type' => $embed_type, 'url' => $url, 'text' => $text, 'style_class' => $class, 'button_color' => $button_color, 'text_color' => $text_color, 'iframe_height' => $iframe_height, 'iframe_width' => $iframe_width];
        return $refined_attributes;
    }

    /**
     * Embeds meeteo widget inline
     */
    protected function embed_inline($atts = array())
    {
        if (!empty($atts)) {
            return "<div class='meeteo-inline-widget' data-url='" . esc_attr($atts['url']) . "' style='min-width: " . esc_attr($atts['iframe_width']) . "; height: " . esc_attr($atts['iframe_height']) . "'></div>";
        }
    }

    /**
     * Embeds meeteo popup text widget
     */
    protected function embed_inline_link($atts = array())
    {
        if (!empty($atts)) {
            return '<p><a target="_blank" class="' . esc_attr($atts['style_class']) . '" href="' . esc_attr($atts['url']) . '" >' . $atts['text'] . '</a></p>';
        }
    }

    /**
     * Embeds meeteo popup text
     */
    protected function embed_popup_text($atts = array())
    {
        return '<a  href="" onclick="Meeteo.initPopupText({url: \'' . esc_attr($atts['url']) . '\'});return false;">' . $atts['text'] . '</a>';
    }

    /**
     * Embeds meeteo popup widget
     */
    protected function embed_popup_widget($atts = array())
    {
        $meeteo_app_id = meeto_api()->meeteo_app_id;
        return '<script type="text/javascript"  id="meeteo-script" >Meeteo.initPopupWidget({ url: \'' . $atts['url'] . '\', text: \'' . $atts['text'] . '\',  appId: \'' . $meeteo_app_id . '\', });</script>';
    }
}