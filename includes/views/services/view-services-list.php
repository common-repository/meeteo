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

        <h2>All Services</h2>
    </div>
    
    <table id="datatable" class="default-table">
        <thead>
            <tr>
                <th class="manage-column ss-list-width">Title</th>
                <th class="manage-column ss-list-width">Description</th>
                <th class="manage-column ss-list-width">Type</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ( ! empty( $services ) ) {
                foreach ( $services as $service ) {
                    ?>
                <tr>
                    <td class="manage-column ss-list-width"><a href="<?php echo $service->company->domain.'/service/'.$service->slug; ?>" target="_blank"><?php echo $service->name; ?></a></td>
                    <td class="manage-column ss-list-width"><?php echo wp_trim_words( $service->description, 10, '...' );; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $service->paymentMode?"Paid":"Free"; ?></td>
                </tr>
                <?php
            }
            } ?>
        </tbody>
    </table>
</div>
