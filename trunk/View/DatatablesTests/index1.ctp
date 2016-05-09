<html>
	<head>
		<!-- DataTables CSS -->
		<link rel="stylesheet" type="text/css" href="/datatables/css/jquery.dataTables.css">
		 
		<!-- jQuery -->
		<script type="text/javascript" charset="utf8" src="/datatables/js/jquery.js"></script>
		 
		<!-- DataTables -->
		<script type="text/javascript" charset="utf8" src="/datatables/js/jquery.dataTables.js"></script>
	</head>
	<body>
	<table id="table_id" class="display">
	    <thead>
	        <tr>
	            <th>Column 1</th>
	            <th>Column 2</th>
	            <th>Column 3</th>
	            
	        </tr>
	    </thead>
	    <tbody>
	        
	    </tbody>
	</table>
	
	</body>
</html>
<script>
$(document).ready( function () {
	$('#table_id').dataTable({
		ajax : {
			url : '/DatatablesTests/index1.json',
			data : {
					"user_id" : "45",
					"password" : "123456"
			}
		},
		columns : [
				{data : "Client.id"},
				{data : "Client.client"},
				{data : "Client.abbr"},
		]
	});
} );

// $(document).ready( function () {
//     $('#table_id').DataTable({
// 		data:data2,
// 		columns:[
// 		         {data:'id'},
// 		         {data:'position'},
// 		         {data:'salary'},
// 		         {data:'start_date'},
// 		         {data:'office'},
// 		         {data:'extn'}
// 		],
// // 		ordering:false,//取消排序
// // 		searching: false,//关闭搜索
// // 		paging: false,//取消分页
//     });
// } );
var data = [
            [
                "Tiger Nixon",
                "System Architect",
                "Edinburgh",
                "5421",
                "2011/04/25",
                "$3,120"
            ],
            [
                "Garrett Winters",
                "Director",
                "Edinburgh",
                "8422",
                "2011/07/25",
                "$5,300"
            ]
        ];
var data2 = [
 {
	 "id":	 		"1",
     "name":       "Tiger Nixon",
     "position":   "System Architect",
     "salary":     "$3,120",
     "start_date": "2011/04/25",
     "office":     "Edinburgh",
     "extn":       "5421"
 },
 {
	 "id":	 		"2",
     "name":       "Garrett Winters",
     "position":   "Director",
     "salary":     "$5,300",
     "start_date": "2011/07/25",
     "office":     "Edinburgh",
     "extn":       "8422"
 }
]
</script>