<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="message">
    <?php
    $message = '';//self::get_message();
    if ( isset( $message ) && ! empty( $message ) ) {
        echo $message;
    }
    ?>
</div>

<div class="meeteo-card">
    <div class="meeteo-card-toolbar">
        <img src="<?php echo MEETEO_PLUGIN_ADMIN_ASSETS_URL . '/img/logo.svg' ?>" alt="logo" />

        <h2>Upcoming Webinars</h2>
    </div>
    
    <table id="datatable" class="default-table">
        <thead>
            <tr>
                <th >Title</th>
                <th >Payment</th>
                <th >Webinar Url</th>
                <th >Start Date</th>
                <th >Webinar Type</th>
                <th >Duration</th>
                <th >Created On</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ( ! empty( $webinars ) ) {
                foreach ( $webinars as $webinar ) {
                    ?>
                <tr>
                    <td ><a href="<?php echo $webinar->shareUrl; ?>" target="_blank"><?php echo $webinar->title; ?></a></td>
                    <td><?php echo $webinar->paymentMode?"Paid":"Free"; ?></td>
                    <td ><?php echo $webinar->webinarUrl; ?></td>
                    <td ><?php echo $webinar->startDate.', '.$webinar->startTime; ?></td>
                    <td ><?php echo $webinar->webinarType->name; ?></td>
                    <td ><?php echo $webinar->duration; ?></td>
                    <td ><?php echo $webinar->createdAt; ?></td>
                </tr>
                <?php
            }
            } ?>
        </tbody>
    </table>
</div>
