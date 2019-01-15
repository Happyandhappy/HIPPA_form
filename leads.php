<?php
    require_once('ApiClient/Client.php');
    if (!isset($_SESSION['user']) || !isset($_SESSION['api'])){
    	header("Location: login.php");
    	exit();
    }
?>


<?php include('layout/header.php');?>
<form class="form-card leads">
    <fieldset class="form-fieldset">
        <legend class="form-legend">HIPPA Leads</legend>
        <!-- Name of Registry -->
        <div class="form-element form-select leads">
            <select id="_name" class="form-element-field" required>
                <option disabled selected value="" class="form-select-placeholder"></option>
                <option value="#device_registry">Device Registry</option>
                <option value="#leads">Leads</option>
                <option value="#contact">Contact</option>
                <option value="#facility">Facility</option>
                <option value="#hardware_inventory">Hardware Inventory</option>
                <option value="#software_inventory">Software Inventory</option>
            </select>
            <div class="form-element-bar"></div>
            <label class="form-element-label" for="_name">Select Lead Name</label>
        </div>
        <div id="device_registry">
            <table id="device-registry" class="table table-striped table-bordered">
                <thead id="device_head">
                </thead>
                <tbody id="device_body">
                </tbody>
            </table>
        </div>
    </fieldset>
<!--     <div class="form-actions">
        <button class="form-btn" type="submit">Send inquiry</button>
    </div> -->
</form>
<?php include('layout/footer.php'); ?>

<script type="text/javascript">    
    $(document).ready(function(){
        client.getAllDeviceRegistry();
        // table = $('#device-registry').DataTable();
    });
</script>