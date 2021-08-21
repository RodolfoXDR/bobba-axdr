<?php if(!isset($_SESSION['alertPassed'])): ?>
<div id="safety-question-dialog" class="modal-dialog">
    <div class="clearfix">
        <h2><?php echo $jRow['Title']; ?></h2>
        <p><?php require KERNEL . '/Cache/Plugin.' . $jRow['Id'] . '.html'; ?></p>

        <p>&nbsp;</p>

        <a href="<?php echo PATH;?>/me?passAlert=true" class="new-button"><b>Ok</b><i></i></a>
    </div>
</div>

<script type="text/javascript">
    HabboView.add(function () {
        if ($("overlay")) {
            $(document.body).appendChild($("safety-question-dialog"));
            Utils.showDialogOnOverlay($("safety-question-dialog"));
        } else {
            $("safety-question-dialog").setStyle({position:'relative', display:'block', margin:'0 auto 2em auto'});
        }
    });
</script>
<?php $_SESSION['alertPassed'] = true;
endif;
?>