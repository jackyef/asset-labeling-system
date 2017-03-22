<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/15/2017
 * Time: 1:26 PM
 */
?>
<div class="row">
    <div class="col-sm-12">
        <div class="pull-left">
            <ol class="breadcrumb">
                <li><a href="<?= base_url()?>">Home</a></li>
                <li>Scan barcode</li>
            </ol>
        </div>
        <div class="clearfix"></div>
        <h2>Scan barcode</h2>

        <br/>
        <form class="form-horizontal" action="<?php echo base_url(); ?>barcode/find" method="POST">
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Barcode:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="item_code" name="item_code" placeholder="Scan a barcode"
                           required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        // fcous on the input field so we can read barcode right away
       $('#item_code').focus();
    });
</script>


