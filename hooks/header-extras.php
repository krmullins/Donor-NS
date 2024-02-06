<script src="hooks/AppGiniHelper.min.js?v=<?=time()?>"></script>


<script>

    var common = AppGiniHelper.getCommon();

    common.setTitle("<b>DonorSoft</b>");

    common.setIcon("gift");

    //AppGiniHelper.getCommon().getNavbar().invert();


</script>



<script>

    var lv = AppGiniHelper.LV;

    if (lv != null) {

        lv.setBackgroundGradient("whitesmoke", "silver")

            .setVariation(Variation.primary) // .success .danger .warning .info

            .setIcons("user", "lock")

            .removeLostPassword()

            .removeRememberMe()

            .removeFooter()

            .center();

    }

</script>
<?php
	/* Inserted by Messages plugin */
	include_once(__DIR__ . '/../plugins/messages/app-resources/icon.php');
	/* End of Messages plugin code */