// 編集と削除インプットに権限CDの入力値を入れる
  function inputCode(){
    AuthorityCode =document.getElementById('PersonCode').value;
    document.getElementById( 'deletePerson' ).value = AuthorityCode ;
    document.getElementById( 'editPerson' ).value = AuthorityCode ;
    document.getElementById( 'copyPerson' ).value = AuthorityCode ;
  }

  function createEdit(){
    if(window.confirm('登録してよろしいですか？')){
        document.PersonForm.submit();
        return true;
    } else {
        return false;
    }
  }

  function destroy(){
    deleteAuthority = document.getElementById('deleteAuthority').value;

    if(deleteAuthority == ''){
      alert( '削除する権限CDを入力するか選択して下さい。' );
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
    editAuthority = document.getElementById('editPerson').value;

    if(editAuthority == ''){
      alert( '編集する権限CDを入力するか選択して下さい。' );
      return false;
    }
  }

  function copyAlert(){
    editAuthority = document.getElementById('copyAuthority').value;

    if(editAuthority == ''){
      alert( 'コピーする権限CDを入力するか選択して下さい。' );
      return false;
    }
  }
  