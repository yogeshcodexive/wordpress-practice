<?php

/* Template Name: Page Builder */

$flexibleContent = get_field("flexible_content");
?>

<?php if (have_rows("flexible_content")):
    while (have_rows("flexible_content")):
        the_row();
        if (get_row_layout() == "hero_section"):
        
        ?>
          

    <!-- <?php elseif (get_row_layout() == "left_right_section"):?> -->


        <?php
      elseif (get_row_layout() == "spacing"):

         $desktop = get_sub_field("desktop");
         $tablet = get_sub_field("tablet");
         $mobile = get_sub_field("mobile");
         $desktop_mb = $desktop["margin_bottom"];
         $desktop_mb_main = !empty($desktop["margin_bottom"]) ? " dpb-" : "";
         $tablet_mb = $tablet["margin_bottom"];
         $tablet_mb_main = !empty($tablet["margin_bottom"]) ? " tpb-" : "";
         $mobile_mb = $mobile["margin_bottom"];
         $mobile_mb_main = !empty($mobile["margin_bottom"]) ? " mpb-" : "";
         $paddingPosition = get_sub_field("padding_position");
         ?>
         <div class="spacing<?php
         echo $desktop_mb_main;
         echo $desktop_mb;
         echo $tablet_mb_main;
         echo $tablet_mb;
         echo $mobile_mb_main;
         echo $mobile_mb;
         ?>" id="<?php echo $paddingPosition == "top"
            ? "spacing-$paddingPosition"
            : "spacing-$paddingPosition"; ?>"></div>
       

<?php endif; endwhile; endif; ?>