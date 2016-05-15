 <style>
 .daterangepicker.dropdown-menu{ z-index:1000}
 </style>
<script type="text/javascript">
	$(document).ready(function(e) {
                 
                //Date range as a button
                $('#daterange-btn').daterangepicker(
                        {
                            ranges: {
                                'Today': [moment(), moment()],
                                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                                'Last 7 Days': [moment().subtract('days', 6), moment()],
                                'Last 30 Days': [moment().subtract('days', 29), moment()],
                                'This Month': [moment().startOf('month'), moment().endOf('month')],
                                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                            },
                            startDate: moment().subtract('days', 29),
                            endDate: moment()
                        },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
                );

                
                 
            
        
    }); 
        </script>
<div id="page-wrapper" style=" position:relative;min-height: 150vh;"  class="right-side">
<br>
<div class="wrapper"> 
    	<div class="col-xs-3">
    <label>Select report Catagory</label>
    	<select onChange="date_range($(this))" class="form-control report_selector">
        	<option >Daily Summery</option>
            <option >Income</option>
            <option >Payments</option>
            <option >Appointments</option>
            <option >Amount due</option>
        </select>
    </div>
    <div class="col-xs-3"></div>
    <div class="col-xs-3">
    <br>
    	<button class="btn btn-default pull-right" id="daterange-btn">
            <i class="fa fa-calendar"></i> Select Date Range
            <i class="fa fa-caret-down"></i>
        </button>
    </div>
    <div class="col-xs-3"></div>
     
	
</div>
 
</div>