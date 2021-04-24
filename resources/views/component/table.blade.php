<style type="text/css">
	table .btn{
		outline: none;
	}
</style>
<table data-role="table" 
	data-actions 
	data-checkbox
	data-type='{{$dataTableType}}' 
	data-data='@json($dataTable)' 
	data-exclude='@json($dataTableExclude)'
	data-transform='@json($dataTableTransform)'>
</table>