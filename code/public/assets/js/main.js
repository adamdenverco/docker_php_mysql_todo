
import { log1, log2, myLog } from './common_functions.js';
console.log('test this');
log1();
log2();

$(document).ready( function () {
  $('#myTodoTable').DataTable({
    "order": [[ 0, "desc" ]]
  });
});

var tdCount = 100;

$( "#new_todo_form form button" ).click(function( event ) {
  var d = new Date();
  event.preventDefault();
  myLog('we clicked submit! ' + d.getTime());

  var todoTable = $("#myTodoTable"),
    todoTableTd = $("#myTodoTable tbody tr td"),
    todoTableDataTable = $("#myTodoTable").DataTable();

  // myLog( todoTable.find('tr').find('td').text() );

  tdCount += 1;

  var rowNode = todoTableDataTable.row.add([
    tdCount, 'check the time: '+ d.getTime(), '(c)', '(e)', '(d)'
  ]).draw().node();

  $( rowNode ).css( 'background-color', '#d1ecf1' ).animate( { 'background-color': 'white' }, 2000 );

});