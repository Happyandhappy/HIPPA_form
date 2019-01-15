<?php
require_once('ApiClient/Client.php');
if (!isset($_SESSION['user']) || !isset($_SESSION['api'])){
    header("Location: login.php");
    exit();
}
?>

<?php include('layout/header.php');?>

<!-- Form -->
<div class="form-card">
    <fieldset class="form-fieldset">
        <legend class="form-legend">HIPPA Form</legend>

        <?php if (isset($error)) {?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Warning!</strong> <?php echo $error; ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        <?php } ?>

        <!-- Name of Registry -->
        <div class="form-element form-select">
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
            <label class="form-element-label" for="_name">Select Registry Name</label>
        </div>

        <!-- Device Registry Form -->
        <form id="device_registry" method="post" data-toggle="validator" role="form">
            <input type="hidden" name="req_name" value="device-registry">
            <!-- Name -->
            <div class="form-element form-input">
                <input id="Name" class="form-element-field" name="Name" placeholder="Please fill in your full name" type="input" required autocomplete="off" />
                <div class="form-element-bar"></div>
                <label class="form-element-label" for="Name">Name</label>
            </div>

            <!-- Active -->
            <div class="form-checkbox form-checkbox-inline">
                <div class="form-checkbox-legend">Active Status?</div>
                <label class="form-checkbox-label">
                    <input name="Active" id="Active" class="form-checkbox-field" type="checkbox" />
                    <i class="form-checkbox-button"></i>
                    <span>Active</span>
                </label>
            </div>
            <div class="row">
                <!-- Assigned_Facility -->                
                <div class="col-sm form-element form-select">
                    <select id="Assigned_Facility" name="Assigned_Facility" class="form-element-field" required>
                        <option disabled selected value="" class="form-select-placeholder"></option>
                        <?php 
                            foreach ($allFacilities as $row) {
                                echo '<option value="' . $row['id'] . '">' . $row['value'] .'</option>';   
                            }
                        ?>
                    </select>
                    <div class="form-element-bar"></div>
                    <label class="form-element-label" for="Assigned_Facility">Select Facility</label>
                </div>

                <!-- IP address -->
                <div class="col-sm form-element form-input">
                    <input id="IP_Address" class="form-element-field" name="IP_Address" placeholder="Please fill in IP Address" type="input" required autocomplete="off"/>
                    <div class="form-element-bar"></div>
                    <label class="form-element-label" for="IP_Address">IP Address</label>
                </div>
            </div>

            <div class="row">
                <!-- Last_Polling_Time -->
                <div class="col-sm form-element form-input">
                    <input id="Last_Polling_Time" class="form-element-field" name="Last_Polling_Time" placeholder="Please fill in IP Address" type="input" required autocomplete="off" disabled=""  value="2017-08-14T16:50:45.000Z" />
                    <div class="form-element-bar"></div>
                    <label class="form-element-label" for="Last_Polling_Time">Last Polling Time</label>
                </div>
                <!-- Polling_Time -->
                <div class="col-sm form-element form-input">
                    <input id="Polling_Time" class="form-element-field" name="Polling_Time" placeholder="Please fill in Polling Time" type="number" required autocomplete="off"/>
                    <div class="form-element-bar"></div>
                    <label class="form-element-label" for="Polling_Time">Polling Time</label>
                </div>  
            </div>
            <div class="row">
                <!-- Organization -->
                <div class="col-sm form-element form-input">
                    <input id="Organization" class="form-element-field" name="Organization" placeholder="Please fill in Organization" type="input" required autocomplete="off" value="<?php  echo($_SESSION['ORGID']); ?>" disabled/>
                    <div class="form-element-bar"></div>
                    <label class="form-element-label" for="Organization">Organization</label>
                </div>


                <!-- User_assigned -->
                <div class="col-sm form-element form-select">
                    <select id="User_assigned" name="User_assigned" class="form-element-field" required>
                        <option disabled selected value="" class="form-select-placeholder"></option>
                    </select>
                    <div class="form-element-bar"></div>
                    <label class="form-element-label" for="User_assigned">Select User assigned</label>
                </div>
            </div>
            <!-- Notes -->
            <div class="form-element form-textarea">
                <textarea id="Notes" class="form-element-field" placeholder=" " name="Notes" required></textarea>
                <div class="form-element-bar"></div>
                <label class="form-element-label" for="Notes">Notes</label>
            </div>

            <div class="form-actions">
                <button class="form-btn btn" type="submit" id="submit">Send Request</button>
            </div>
        </form>        

        <!-- Leads Entry Form -->
        <form id="leads"  method="post" data-toggle="validator" role="form"></form>

        <!-- Contact Entry Form -->
        <form id="contact"  method="post" data-toggle="validator" role="form"></form>

        <!-- Facility Entry Form -->
        <form id="facility"  method="post" data-toggle="validator" role="form"></form>

        <!-- Hardware Inventory Entry Form -->
        <form id="hardware_inventory" method="post" data-toggle="validator" role="form"></form>

        <!-- Software Inventory Entry Form -->
        <form id="software_inventory" method="post" data-toggle="validator" role="form"></form>
    </fieldset>
</div>
<?php include('layout/footer.php'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        // $('.animationload').addClass('hidden');
        client.getallFacilities();
        client.getallContacts();
        $('#device_registry').on('submit', function (e) {
            e.preventDefault();
            if ($('#submit').hasClass('disabled')) return;
            client.insertDeviceRegistry();
        });
    });
</script>