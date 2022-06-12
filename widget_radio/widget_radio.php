<?php
/*
 * Plugin Name: Widget Radio
 * Plugin URI: http://example.com/widget-radio/ 
 * Description: Anropar ett API för att hämta in en xml-fil innehållande radiostation från Örebro.
 * Version: 1.0
 * Author: Lotta Ollander
 * Author URI: http://example.com
 * License: GPLv2
 */

add_action( 'widgets_init', function() {
    register_widget( 'Widget_Radio'); 
});

class widget_Radio extends WP_Widget {
    public function __construct() {
        parent::WP_Widget(false,'Widget Radio','description=Basfunktioner för ett API-anrop i en widget.'); // denna talar om att det är en vanlig widget
        wp_enqueue_style( 'Widget_Radio_CSS', plugins_url( '/widget_radio_style.css', __FILE__ ) ); // stylesheet kopplingen till min css fil
    }

    public function widget($args, $instance) {
        // Hämta in alla argument
		extract ($args);
        

        $url = "http://api.sr.se/api/v2/playlists/rightnow?channelid=221&format=json";
        $contents = file_get_contents($url); // är frågan som sker och den hämtar url och sparas undan
        $contents = json_decode($contents, true); // här översätts json till arrayformat
        
        // Kollar om svaret blev tomt med ett felmeddelande
        if (!$contents) {
            echo $before_widget;
            echo $before_title . $instance['title'] . $after_title;
            echo $before_artist . $instance['artist'] . $after_artist;
            echo '<div class="widget_Radio">' .
                '<br>Error. Sändningen misslyckades' .
                '</div>';
            echo $after_widget;
        }
       
        else {
            // Hämtar in informationen visar upp vilken låt det är som spelas
            $singalong     = strip_tags($contents['playlist']['song']['title']);
            $artist    = strip_tags($contents['playlist']['song']['artist']);
            ?>
            <div class="widget_Radio">
             <?php echo $before_title . $instance['title'] . $after_title;  ?>
             <?php echo $before_artist . $instance['artist'] . $after_artist;  ?>
                <div class="exempeltext"><p class="bigger">Lyssna på snack eller låten som spelas nu</p> <p><?php echo " låt " . $singalong . " av " . $artist; ?></p></div>
                
            <!--Spelar upp radio 221 är kopplat till p4Örebro-->
            <figure>
            <figcaption>P4 Örebro</figcaption>
            <audio
                controls
                src="https://sverigesradio.se/topsy/direkt/srapi/221.mp3">
                    Your browser does not support the
                    <code>audio</code> element.
            </audio>
        </figure>
        </div>
           <?php
        }
    }

    // tar in titeln och kör en uppdatering
    public function update ($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
        return $instance;
    }

    public function form ($instance) {
        // Hämtar ut de delar vi vill visa upp i widget options
		$title = esc_attr ($instance['title']);
		?>
		<p>
            <label 
                for="<?php echo $this->get_field_id('title'); ?>">
                Titel på widget: <input class="widefat" 
                id="<?php echo $this->get_field_id('title'); ?>" 
                name="<?php echo $this->get_field_name('title'); ?>" 
                type="text" 
                value="<?php echo $title; ?>" />
            </label>
		</p>
		<?php
    }
} 
?>
