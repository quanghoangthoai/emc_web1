@if ($check_comment == true && $module_id != null)
<div id="comment"></div>
@endif
<script>
    $(document).ready(function(){
            $('#comment').load('{{ route('mod_comment.web.loadcomment',['id'=>$post['id'],'module'=>$module,'link'=>$link]) }}');

});
</script>