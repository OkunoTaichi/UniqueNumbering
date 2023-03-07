function inputCode(){
    BuildingCode =document.getElementById('BuildingCode').value;
    document.getElementById( 'edit_search' ).value = BuildingCode ;
    document.getElementById( 'delete_search' ).value = BuildingCode ;
    document.getElementById( 'copy_search' ).value = BuildingCode ;
    
  }

function createAlert(){
  if(window.confirm('登録してよろしいですか？')){
      document.BuildingForm.submit();
      return true;
  } else {
      return false;
  }
}

function destroyAlert(){
  delete_flag = document.getElementById('delete_search').value;

  if(delete_flag == ''){
    alert( '削除する棟コードを選択して下さい。' );
    return false;
  }else{

    if(window.confirm('削除してよろしいですか？')){
        return true;
    } else {
        return false;
    }
  }
}

function editAlert(){
  edit_flag = document.getElementById('edit_search').value;

  if(edit_flag == ''){
    alert( '編集する棟コードを選択して下さい。' );
    return false;
  }
}

function copyAlert(){
  copy_flag = document.getElementById('edit_search').value;

  if(copy_flag == ''){
    alert( 'コピーする棟コードを選択して下さい。' );
    return false;
  }
}

// function pasteAlert(){
//   paste_flag = document.getElementById('copy_search').value;

//   if(paste_flag == ''){
//     alert( 'コピーしていません。' );
//     return false;
//   }
// }