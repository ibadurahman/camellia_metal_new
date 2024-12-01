<!DOCTYPE html>
<html lang="en">
<style>
    body {
        margin: 0px;
        padding: 0px;
    }

    @page  {
        margin-left: 0px;
        margin-top: 30px;
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<body>
    <table style="margin-left: 1px; border: 1px solid black">
        <tr>
            <td width="200px">
                <table width="100%" style="margin-left: 1px">
                    <tr>
                        <td style="text-align: center; font-size: 10px">
                            <center><b><?php echo e($title); ?></b></center>
                        </td>
                    </tr>
                    <tr style="margin: 0px; padding: 0px">
                        <td
                            style="
                                    font-size: 6px;
                                    margin: 0px;
                                    padding: 0px;
                                ">
                            <center>
                                <b>A Subsidiary of Camellia Metal Co.
                                    Ltd</b>
                            </center>
                        </td>
                    </tr>
                    <tr style="margin: 0px; padding: 0px">
                        <td
                            style="
                                    font-size: 6px;
                                    margin: 0px;
                                    padding: 0px;
                                ">
                            <center>
                                <b>JL. RAMIN 1 BLOK G6 No.9 DELTA SILICON
                                    VI LIPPO CIKARANG</b>
                            </center>
                        </td>
                    </tr>
                    <tr style="margin: 0px; padding: 0px">
                        <td
                            style="
                                    font-size: 6px;
                                    margin: 0px;
                                    padding: 0px;
                                ">
                            <center>
                                <b>DESA JAYA MUKTI, CIKARANG PUSAT, BEKASI
                                    17530</b>
                            </center>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td
                                        style="
                                                padding-right: 50px;
                                                font-size: 10px;
                                            ">
                                        <b>Grade</b>
                                    </td>
                                    <td
                                        style="
                                                margin: 1px;
                                                padding: 1px;
                                                width: 1px;
                                            ">
                                        :
                                    </td>
                                    <td
                                        style="
                                                border: 1px solid black;
                                                width: 90px;
                                                padding-left: 10px;
                                                font-size: 12px;
                                            ">
                                        <b><?php echo e($data->bb_grade); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 10px">
                                        <b>Size (mm)</b>
                                    </td>
                                    <td>:</td>
                                    <td
                                        style="
                                                border: 1px solid black;
                                                padding-left: 10px;
                                                font-size: 12px;
                                            ">
                                        <b>
                                            <?php echo e(strtolower($data->fg_shape) == 'hexagon' ? 'HEX' : ''); ?>

                                            <?php echo e(strtolower($data->fg_shape) == 'square' ? 'SQ' : ''); ?>

                                            <?php echo e($data->fg_size_1); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 10px">
                                        <b>Tolerance (mm)</b>
                                    </td>
                                    <td>:</td>
                                    <td
                                        style="
                                                border: 1px solid black;
                                                padding-left: 10px;
                                                font-size: 12px;
                                            ">
                                        <b>(<?php echo e((substr($data->tolerance_plus, 0, 1) !== '-' ? '+' : '') . $data->tolerance_plus); ?>,
                                            <?php echo e($data->tolerance_minus); ?>)</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 10px">
                                        <b>Length (mm)</b>
                                    </td>
                                    <td>:</td>
                                    <td
                                        style="
                                                border: 1px solid black;
                                                padding-left: 10px;
                                                font-size: 12px;
                                            ">
                                        <b><?php echo e($data->fg_size_2); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 10px">
                                        <b>Bundle</b>
                                    </td>
                                    <td>:</td>
                                    <td
                                        style="
                                                border: 1px solid black;
                                                padding-left: 10px;
                                                font-size: 12px;
                                            ">
                                        <b><?php echo e($production->bundle_num); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 10px">
                                        <b>N. WT</b>
                                    </td>
                                    <td>:</td>
                                    <td
                                        style="
                                                border: 1px solid black;
                                                vertical-align: top;
                                                padding-left: 10px;
                                                font-size: 12px;
                                            ">
                                        <b><?php echo e($production->berat_fg); ?></b>
                                    </td>
                                </tr>
                                <!-- <tr style="height: 2px;">
                                        <td></td>
                                    </tr> -->
                                <tr>
                                    <td style="font-size: 10px">
                                        <b>Job No.</b>
                                    </td>
                                    <td>:</td>
                                    <td
                                        style="
                                                border: 1px solid black;
                                                padding-left: 10px;
                                                font-size: 12px;
                                            ">
                                        <b><?php echo e($data->wo_number); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 10px">
                                        <b>Mesin</b>
                                    </td>
                                    <td>:</td>
                                    <td
                                        style="
                                                border: 1px solid black;
                                                padding-left: 10px;
                                                font-size: 12px;
                                            ">
                                        <b><?php echo e($data->machine->name); ?></b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%">
                                <tr>
                                    <td style="font-size: 8px">
                                        <b>Made in Indonesia</b>
                                    </td>
                                    <?php if($data->label_remarks): ?>
                                        <td style="font-size: 8px">
                                            <b><?php echo e($data->label_remarks); ?></b>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
<?php /**PATH D:\2. Dokumen Ibad\11. Personal Business\Projects\2. Running\Camellia Maintenance\test_env\resources\views\user\pdf\index.blade.php ENDPATH**/ ?>