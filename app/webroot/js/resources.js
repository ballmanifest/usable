var FilocityTasks={

	tasks: null,
	subtasks: null,
	documents: null,
	
	listTasks:function(){
		var data=FilocityTasks.tasks;
		var taskOptions={
			updated: function(div, data){
				if(data['task']['status']!=1){
					if($(div).parent().parent().attr('id')!='active_tasks'){
						$(div).appendTo($('#active_tasks .container'));
					}
				}else{
					if($(div).parent().parent().attr('id')!='pending_tasks'){
						$(div).appendTo($('#pending_tasks .container'));
					}
				}
			}
		};
		var Fsubtasks=FilocityTasks.subtasks;
		var Fdocuments=FilocityTasks.documents;
		for(var x in data){  
			var sub_tasks=[];
			var sub_docs=[];
			for(var i=0,iCount=Fsubtasks.length;i<iCount;i++){
				if(Fsubtasks[i]['Subtask']['task_id']!=data[x]['Task']['id']){
					continue;
				}
				sub_tasks.push(Fsubtasks[i]);
			}
			for(var i=0,iCount=Fdocuments.length;i<iCount;i++){
				if(Fdocuments[i]['Share']['task_id']!=data[x]['Task']['id']){
					continue;
				}
				sub_docs.push(Fdocuments[i]);
			}

			if(data[x]['Task']['status']!=1){
				FilocityTasksHelper.displayTask({task:data[x]['Task'],comment:data[x]['Comment'], subtasks:sub_tasks, actitivies:[],documents:sub_docs}, '#active_tasks .container', taskOptions);
			}else{
				FilocityTasksHelper.displayTask({task:data[x]['Task'], comment:data[x]['Comment'],subtasks:sub_tasks, actitivies:[],documents:sub_docs}, '#pending_tasks .container', taskOptions);
			}
		}
		var newTaskOptions=taskOptions;
		newTaskOptions.displayed=function(div){
			$(div).find('.arrow').click();
		}
		$('#new_task_link').click(function(){
			FilocityTasksHelper.displayTask(FilocityTasksHelper.newTaskData, '#pending_tasks .container', newTaskOptions);
			return false;
		});
	},
	
	loadAllTasks:function(){
            
		var view='';
		if(FilocityTasks.view!='' && FilocityTasks.view_id!=0){
			view='/'+FilocityTasks.view+'/'+FilocityTasks.viewed_id;
		}
        view+='/'+FilocityTasks.sort_by;               
		var load_tasks_ajax=$.ajax({
			url: _ROOT+'tasks/get_resources_tasks'+view,
			type: 'POST',
			dataType: 'JSON',
			success: function(data){ 
				FilocityTasks.tasks=data['tasks'];
				FilocityTasks.subtasks=data['subtasks'];
				FilocityTasksHelper.users=data['users'];
				FilocityTasks.documents=data['documents'];
				FilocityTasks.listTasks();
                                $('#tasks_dropdown').val(FilocityTasks.sort_by)
			},
			error: function(err){
				alert(err.responseText);
			}
		});
	},
	
	saveTasksOrder: function(task_ids){
		var order_tasks_ajax=$.ajax({
			url: _ROOT+'tasks/save_tasks_order',
			data: {data: {order: task_ids}},
			type: 'POST',
			dataType: 'JSON',
			success: function(data){
				
			},
			error: function(err){
				alert(err.responseText);
			}
		});
	},
	
	initDragAndDrop: function(){
		var sortingOptions={
			cursor: 'move',
			helper: 'clone',
			stop: function(event, ui){
				var order=[];
				var task_ids=$('[data-task-id]');
				for(var i=0;i<task_ids.length;i++){
					var task_id=$(task_ids[i]).attr('data-task-id');
					if(task_id==0){
						continue;
					}
					order.push(task_id);
				}
				FilocityTasks.saveTasksOrder(order);
			}
		};
		$('#active_tasks .container').sortable(sortingOptions);
		$('#pending_tasks .container').sortable(sortingOptions);
	},
	
	init: function(){
		$(function(){
			FilocityTasks.initDragAndDrop();
			FilocityTasks.loadAllTasks();
		});
		$('#projects_dropdown').on('change',function(){
			var parts=$(this).val().split('-');
			if(parts[1]==0){
				location.href=_ROOT+'users/resources';
				return;
			}
			location.href=_ROOT+'users/resources/'+parts[0]+'/'+parts[1]+'/'+FilocityTasks.sort_by;
		});
                $('#tasks_dropdown').on('change',function(){
			var sort_by=$(this).val();
                        var url=sort_by;
                       if(FilocityTasks.viewed_id!=0) 
                          {  
                              url=FilocityTasks.view+'/'+FilocityTasks.viewed_id+'/'+url;
                          }                           
			location.href=_ROOT+'users/resources/'+url;
		});
	},
	
	view: '',
	viewed_id: 0
}