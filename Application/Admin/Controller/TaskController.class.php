<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
class TaskController extends AdminBaseController{
    /**
     * 获取任务信息
     */
    public function get_task_info(){
        $ms = D('Task');
        $cond = [
            't.status' => C('STATUS_Y')
        ];

        $recordsTotal = $ms->alias('t')->where($cond)->count();

        // 搜索
        $search = I('search');
        $searchProject = I('project_name');
        $searchTask = I('task_name');
        $searchPublishDate = I('publish_time');
        $searchDeadlineDate = I('deadline_time');
        if (strlen($search)>0) {
            $cond['project_name|project_type_name|project_desc'] = array('like', '%'.$search.'%');
        }
        if ($searchProject) $cond['project_name'] = $searchProject;
        if ($searchTask) $cond['task_name'] = $searchTask;
        if ($searchPublishDate) $cond['publish_time'] = array('between', [$searchPublishDate.' 00:00:01', $searchPublishDate.' 23:59:59']);
        if ($searchDeadlineDate) $cond['deadline_time'] = array('between', [$searchDeadlineDate.' 00:00:01', $searchDeadlineDate.' 23:59:59']);

        $recordsFiltered = $ms->getTaskNumber($cond);

        // 排序
        $orderObj = I('order')[0];
        $orderColumn = $orderObj['column'];
        $orderDir = $orderObj['dir'];
        if(isset(I('order')[0])){
            $i = intval($orderColumn);
            switch($i){
                case 0: $ms->order('project_name '.$orderDir); break;
                case 1: $ms->order('task_name '.$orderDir); break;
                case 2: $ms->order('executive.member_name '.$orderDir); break;
                case 3: $ms->order('publisher.member_name '.$orderDir); break;
                case 4: $ms->order('publish_time '.$orderDir); break;
                case 5: $ms->order('deadline_time '.$orderDir); break;
                case 6: $ms->order('complete_time '.$orderDir); break;
                case 7: $ms->order('status '.$orderDir); break;
                default: break;
            }
        } else {
            $ms->order('publish_time');
        }

        // 分页
        $start = I('start');
        $limit = I('limit');
        $page = I('page');

        $infos = $ms->page($page, $limit)->getTaskData($cond);

        echo json_encode(array(
            "draw" => intval(I('draw')),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $infos
        ), JSON_UNESCAPED_UNICODE);
    }

    /**
     * 修改任务
     */
    public function edit_task()
    {
        $taskId = I('id');

        if ($taskId) {
            $task = D('Task');
            $cond['id'] = $taskId;
            $data = I('post.');
            $res = $task->editTask($cond, $data);

            if ($res === false) {
                ajax_return(0, '修改任务信息出错');
            }
            ajax_return(1, '修改任务信息成功');
        }

        ajax_return(0, '传递参数不合法');
    }

    /**
     * 删除任务
     */
    public function delete_task()
    {
        $taskId = I('id');

        if ($taskId) {
            $res = D('Task')->deleteTask($taskId);
            if ($res === false) {
                ajax_return(0, '删除任务出错');
            }
            ajax_return(1, '删除项目成功');
        }

        ajax_return(0, '传递参数不合法');
    }
}
