<?php

use \WPFW\Forms\Form;
use WPFW\Utils\Xml;

class rajce_widget extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct( false, $name = __( 'Rajče - seznam galerii' ) );//widget title on administration list
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance )
    {
        // outputs the content of the widget

        extract( $args, EXTR_SKIP );

        $rajce_title = apply_filters( 'rajce_url', isset( $instance['rajce_title'] ) ? $instance['rajce_title'] : NULL );
        $rajce_url = apply_filters( 'rajce_url', isset( $instance['rajce_url'] ) ? $instance['rajce_url'] : NULL );
        $rajce_count_gallery = apply_filters( 'rajce_count_gallery', isset( $instance['rajce_count_gallery'] ) ? $instance['rajce_count_gallery'] : NULL );

        $rajce_show_date = apply_filters( 'rajce_show_date', isset( $instance['rajce_show_date'] ) ? $instance['rajce_show_date'] : NULL );
        $rajce_remove_server_name = apply_filters( 'rajce_remove_server_name', isset( $instance['rajce_remove_server_name'] ) ? $instance['rajce_remove_server_name'] : NULL );
        $rajce_open_in_new_window = apply_filters( 'rajce_open_in_new_window', isset( $instance['rajce_open_in_new_window'] ) ? $instance['rajce_open_in_new_window'] : NULL );

        $galleryURL = $rajce_url . "?rss=news";


        $widget_content = "";

        $aXmlGallery = Xml::parseXMLtoArray( $galleryURL );

        if( $rajce_remove_server_name == true )
        {
            $galleryUser = Widget::getGalleryUser( $aXmlGallery['channel']['title'] );
        }

        $i = 0;
        foreach( $aXmlGallery['channel']['item'] as $item )
        {
            $i++;

            $title = $item['title'];
            if( $rajce_remove_server_name == true )
            {
                //remove from gallery name user name
                $title = str_replace( $galleryUser . " | ", "", $title );
            }

            $widget_content .= "<div class=\"rajce-row\">";
            $widget_content .= "<a href=\"{$item['link']}\"";
            if( $rajce_open_in_new_window == TRUE )
            {
                $widget_content .= " target=\"_blank\"";
            }
            $widget_content .= ">{$title}";
            if( $rajce_show_date == TRUE )
            {
                //show date
                $date = new DateTime( $item['pubDate'] );
                $widget_content .= $date->format( 'd.m.Y H:i' );
            }
            $widget_content .= "<div style=\"text-align: center;\">";
            $widget_content .= "<img src=\"{$item['image']['url']}\">";
            $widget_content .= "</div>";
            $widget_content .= "</a>";
            $widget_content .= "</div>";

            if( $i >= $rajce_count_gallery )
            {
                //end of showing gallery
                break;
            }
        }

        echo $before_widget;

        if( !empty( $rajce_title ) )
        {
            echo $before_title . $rajce_title . $after_title;
        }
        if( !empty( $widget_content ) )
        {
            echo $widget_content;
        }

        echo $after_widget;
    }


    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance )
    {
        // outputs the options form in admin

        $rajce_title = $this->getVariableValue( $instance, 'rajce_title' );
        $rajce_url = $this->getVariableValue( $instance, 'rajce_url' );
        $rajce_count_gallery = $this->getVariableValue( $instance, 'rajce_count_gallery' );
        $rajce_show_date = $this->getVariableValue( $instance, 'rajce_show_date' );
        $rajce_remove_server_name = $this->getVariableValue( $instance, 'rajce_remove_server_name' );
        $rajce_open_in_new_window = $this->getVariableValue( $instance, 'rajce_open_in_new_window' );

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $form = new Form();
        $form->addGroup('Povinné Informace o galerii');
        $form->addText( $this->get_field_id( "rajce_title" ), $this->get_field_name( "rajce_title" ), "Titulek boxu:" )->setValue( $rajce_title );
        $form->addText( $this->get_field_id( "rajce_url" ), $this->get_field_name( "rajce_url" ), "Adresa galerie:" )->setValue( $rajce_url );
        $form->addText( $this->get_field_id( "rajce_count_gallery" ), $this->get_field_name( "rajce_count_gallery" ), "Počet alb:" )->setValue( $rajce_count_gallery );
        $form->addGroup('Volitelné funkce');
        $form->addCheckbox( $this->get_field_id( "rajce_show_date" ), $this->get_field_name( "rajce_show_date" ), "Zobraz datum:" )->setValue( $rajce_show_date )->setOption('description', 'Datum zalození galerie');
        $form->addCheckbox( $this->get_field_id( "rajce_remove_server_name" ), $this->get_field_name( "rajce_remove_server_name" ), "Skrýt název serveru:" )->setValue( $rajce_remove_server_name )->setOption('description', 'Název serveru je součástí každé galerie');
        $form->addCheckbox( $this->get_field_id( "rajce_open_in_new_window" ), $this->get_field_name( "rajce_open_in_new_window" ), "Otevřít v novém okně:" )->setValue( $rajce_open_in_new_window )->setOption('description', 'Galerie se otevře v novém okně');

        echo $form;

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    }

    /**
     * Get variable from instance
     * @param $instance
     * @param $variableName
     * @return string
     */
    private function getVariableValue( $instance, $variableName )
    {
        $instance = wp_parse_args( (array)$instance );

        $variable = "";
        if( !empty( $instance[$variableName] ) )
        {
            $variable = $instance[$variableName];
        }

        return $variable;
    }

    /**
     * Save widget data
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;

        foreach( $new_instance as $key => $new_inst_detail )
        {
            $instance[$key] = esc_sql( $new_inst_detail );
        }

        return $instance;
    }

}

//PHP 5.2+:
add_action( 'widgets_init', create_function( '', 'return register_widget("rajce_widget");' ) );
