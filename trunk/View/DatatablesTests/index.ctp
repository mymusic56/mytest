<html>
	<head>
		<!-- DataTables CSS -->
		<link rel="stylesheet" type="text/css" href="/datatables/css/jquery.dataTables.css">
		 
		<!-- jQuery -->
		<script type="text/javascript" charset="utf8" src="/datatables/js/jquery.js"></script>
		 
		<!-- DataTables -->
		<script type="text/javascript" charset="utf8" src="/datatables/js/jquery.dataTables.js"></script>
		<script src="/My97DatePicker/WdatePicker.js"></script>
	</head>
	<body>
	<table id="table_id" class="display">
	   
	</table>
	
	</body>
</html>
<script>
$(document).ready( function () {
	var table = $('#table_id').dataTable({
		"dom": '<"toolbar">frtip',
		"ajax" : {
			url : '/DatatablesTests/index.json',
// 			data : {
// 					"user_id" : "45",
// 					"password" : "123456",
// // 					"start_time" : $("#start_time").val()
// 			},
			"data": function ( d ) {//Custom HTTP variables;获取通过自定义toolbar的值
                d.myKey = "myValue";
                d.start_time = $("#start_time").val();
                d.end_time = $("#end_time").val();
            },
			dataSrc : "data21",//Custom data source property; 后台在返回数据的时候可以自定义键名
// 			type : 'post',//提交方式
		},
		
		"columns" : [
		           {title : "id"},
		           {title : "client"},
		           {title : "abbr"}
		],
		"processing" : true,
        "serverSide" : true,
        "lengthMenu" : [[10, 25, 50, -1], [10, 25, 50, "All"]],//第一个数组是真实传递的 limit, 第二个数组是显示的 limit
        "displayLength" : 25,//默认显示几条数据
        "order" : [[0, "desc"], [1, "asc"]], //多列排序
        "language": {
            "lengthMenu": "每页显示 _MENU_ 条记录",
            "zeroRecords": "Nothing found - sorry",
            "info": "显示第 _PAGE_ 页，共 _PAGES_页",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },
        "scrollY": "400px",
        "initComplete": function () {//点击单元格搜索
            var api = this.api();
            api.$('td').click( function () {
                api.search( this.innerHTML ).draw();
            } );
        }
	});
	//Custom toolbar elements
	$("div.toolbar").html('时间<input id="start_time" onclick="WdatePicker({isShowClear:true,readOnly:true, dateFmt:\'yyyy-MM-dd\'})"  value=""/>-<input id="end_time" onclick="WdatePicker({isShowClear:true,readOnly:true, dateFmt:\'yyyy-MM-dd\'})"  value=""/>');
	/*
	* 选中行高亮显示
	*/
	$('#table_id tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
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