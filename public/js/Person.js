
  function inputCode(){
    AuthorityCode =document.getElementById('PersonCode').value;
    document.getElementById( 'deletePerson' ).value = AuthorityCode ;
    document.getElementById( 'editPerson' ).value = AuthorityCode ;
    document.getElementById( 'copyPerson' ).value = AuthorityCode ;
  }

  function createPerson(){
    if(window.confirm('登録してよろしいですか？')){
        document.PersonForm.submit();
        return true;
    } else {
        return false;
    }
  }

  function destroy(){
    deletePerson = document.getElementById('deletePerson').value;

    if(deletePerson == ''){
      alert( '削除する権限CDを選択して下さい。' );
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
    editPerson = document.getElementById('editPerson').value;

    if(editPerson == ''){
      alert( '編集する権限CDを選択して下さい。' );
      return false;
    }
  }

  function copyAlert(){
    editPerson = document.getElementById('copyPerson').value;

    if(editPerson == ''){
      alert( 'コピーする権限CDを選択して下さい。' );
      return false;
    }
  }




  