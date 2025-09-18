<?php
if (isset($_SESSION["flash"])) {
?>
    <script>
        let flash = {
            type: "<?= $_SESSION['flash']['type'] ?>",
            message: "<?= $_SESSION['flash']['msg'] ?>"
        };
    </script>
    <?php unset($_SESSION["flash"]); ?>
<?php
}
?>