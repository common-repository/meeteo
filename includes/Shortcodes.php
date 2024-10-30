<?php

namespace Meeteo\WPApi;

use Meeteo\WPApi\Shortcodes\Meeteo_Embed;

defined('ABSPATH') || exit;

class Meeteo_Shortcodes
{
    public function __construct()
    {
        define('MEETEO_INLINE_EMBED', 'inline');
        define('MEETEO_INLINE_LINK_EMBED', 'inline_link');
        define('MEETEO_POPUP_TEXT_EMBED', 'popup_text');
        define('MEETEO_POPUP_WIDGET_EMBED', 'popup_widget');  //go to footer
        $embed = Meeteo_Embed::get_instance();
        add_shortcode('meeteo_webinar', array($this, 'show_webinar_by_ID'));
        add_shortcode('meeteo_upcoming_webinars', array($this, 'list_upcoming_webinars'));
        add_shortcode('meeteo_services', array($this, 'list_services'));
        add_shortcode('meeteo_embed', array($embed, 'embed_widget'));
    }

    /**
     * Display the webinar by ID
     * @param $attributes
     * @return false|string
     */
    public function show_webinar_by_ID($attributes)
    {
        $atts = shortcode_atts(
            [
                'webinar_id' => ''
            ], $attributes);
        $webinars_result = meeto_api()->getWebinarById(['webinarId' => $atts['webinar_id']]);
        $webinars_data = json_decode($webinars_result);
        if (($webinars_data->success)) {
            $webinar = $webinars_data->data->data;
        } else {
            return $webinars_data->message;
        }
        ob_start();
        ?>
        <hr>
        <p><strong> Name of the webinar: <?php echo $webinar->title; ?></strong></p>
        <hr>
        <table class="me-table">
            <tbody>
            <tr>
                <td width="120px">Title</td>
                <td class="manage-column ss-list-width"><a href="<?php echo $webinar->shareUrl; ?>" target="_blank"><?php echo $webinar->title; ?></a></td>
            </tr>
            <tr>
                <td>Description</td>
                <td class="manage-column ss-list-width"><?php echo $webinar->description; ?></td>
            </tr>
            <tr>
                <td>Payment</td>
                <td class="manage-column ss-list-width"><?php echo $webinar->paymentMode?"Paid":"Free"; ?></td>
            </tr>
            <tr>
                <td>Duration</td>
                <td class="manage-column ss-list-width"><?php echo $webinar->duration; ?></td>
            </tr>
            <tr>
                <td>Start Date</td>
                <td class="manage-column ss-list-width"><?php echo $webinar->startDate; ?></td>
            </tr>
            <tr>
                <td>Start Time</td>
                <td class="manage-column ss-list-width"><?php echo $webinar->startTime.' to '. $webinar->endTime;; ?></td>
            </tr>
            <tr>
                <td>Webinar Type</td>
                <td class="manage-column ss-list-width"><?php echo $webinar->webinarType->name; ?></td>
            </tr>
            <tr>
                <td>Webinar Invitees</td>
                <td class="manage-column ss-list-width">
                    <?php
                    $invData = '-';
                    if($webinar->invitees){
                        $invData = "<ul>";
                    foreach ($webinar->invitees as $invitee){
                        $invData .="<li>$invitee->name ($invitee->roleName)</li>";
                    }$invData .= "<ul>";}
                    echo $invData;?>
                </td>
            </tr>
            </tbody>
        </table>
        <?php
        return ob_get_clean();
    }

    /**
     * Show List of upcoming webinars.
     * @param $atts
     * @return false|string|void
     */
    public function list_upcoming_webinars($attributes)
    {
        $atts = shortcode_atts(
            [
                'max' => '5'
            ], $attributes);
        $webinars_result = meeto_api()->listWebinar(['limit' => $atts['max']]);
        $webinars_data = json_decode($webinars_result);
        if (($webinars_data->success)) {
            $webinars = $webinars_data->data->data;
        } else {
            return $webinars_data->message;
        }
        ob_start();
        ?>
        <table class="me-table">
            <thead>
            <tr>
                <th>Title</th>
                <th>Payment</th>
                <th>Start Date</th>
                <th>Webinar Type</th>
                <th>Duration</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($webinars)) {
                foreach ($webinars as $webinar) {
                    ?>
                    <tr>
                        <td class="manage-column ss-list-width"><a href="<?php echo $webinar->shareUrl; ?>" target="_blank"><?php echo $webinar->title; ?></a></td>
                        <td class="manage-column ss-list-width"><?php echo $webinar->paymentMode?"Paid":"Free"; ?></td>
                        <td class="manage-column ss-list-width"><?php echo $webinar->startDate.', '.$webinar->startTime; ?></td>
                        <td class="manage-column ss-list-width"><?php echo $webinar->webinarType->name; ?></td>
                        <td class="manage-column ss-list-width"><?php echo $webinar->duration; ?></td>
                    </tr>
                    <?php
                }
            } ?>
            </tbody>
        </table>
        <?php
        return ob_get_clean();
    }

    /**
     * Show List of upcoming webinars.
     * @param $atts
     * @return false|string|void
     */
    public function list_services($attributes)
    {
        $atts = shortcode_atts(
            [
                'max' => '5'
            ], $attributes);
        $services_result = meeto_api()->listService(['limit' => $atts['max']]);
//        return json_encode($webinars_result);
        $services_data = json_decode($services_result);
        if (($services_data->success)) {
            $services = $services_data->data->data;
        } else {
            return $services_data->message;
        }
        ob_start();
        ?>
        <table class="me-table">
            <thead>
            <tr>
                <th class="manage-column ss-list-width">Title</th>
                <th class="manage-column ss-list-width">Description</th>
                <th class="manage-column ss-list-width">Type</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($services)) {
                foreach ($services as $service) {
                    ?>
                    <tr>
                        <td class="manage-column ss-list-width"><a href="<?php echo $service->company->domain.'/service/'.$service->slug; ?>" target="_blank"><?php echo $service->name; ?></a></td>
                        <td class="manage-column ss-list-width"><?php echo wp_trim_words($service->description, 10, '...');; ?></td>
                        <td class="manage-column ss-list-width"><?php echo $service->paymentMode?"Paid":"Free"; ?></td>
                    </tr>
                    <?php
                }
            } ?>
            </tbody>
        </table>
        <?php
        return ob_get_clean();
    }
}

new Meeteo_Shortcodes();
