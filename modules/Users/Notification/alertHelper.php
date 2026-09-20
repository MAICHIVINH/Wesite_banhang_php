<?php
function swal_alert($icon, $title, $text = '', $redirect = null)
{
    // echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    // <script>
    //     Swal.fire({
    //         icon: '$icon',
    //         title: '$title',
    //         text: '$text',
    //         showConfirmButton: false,
    //         timer: 2000
    //     }).then(() => {
    //         " . ($redirect ? "window.location.href = '$redirect';" : "") . "
    //     });
    // </script>";

    $icon = addslashes($icon);
    $title = addslashes($title);
    $text = addslashes($text);
    $redirectScript = $redirect ? "window.location.href = '$redirect';" : '';

    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: '$icon',
            title: '$title',
            text: '$text',
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            $redirectScript
        });
    </script>";
}
