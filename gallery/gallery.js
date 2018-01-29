function deletePicture(id, ok) {
    if (ok === 1) {
        document.getElementById('delete_'+id).parentNode.remove();
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "deletepic.php?id_pic="+id, true);
        xhr.send();
        alert("Montage supprimé");
    }
    else {
        alert("Vous n'avez pas le droit de supprimer ce montage. Seul son auteur y est autorisé.");
        return (false);
    }
  }

  function addLike(id, addlikecom) {
      if (addlikecom === 1) 
        {
            let likesnode_before = document.getElementById('nblikes_'+id);
            let likesnode_clone = likesnode_before.cloneNode(true);
              string_likes = likesnode_before.textContent;
            let tab_likes = string_likes.split(" ");
            let nb_likes = tab_likes.shift(tab_likes);
            nb_likes = Number(nb_likes);
            nb_likes++;
            likesnode_clone.innerHTML = nb_likes.toString()+' likes';
            likesnode_before.parentNode.appendChild(likesnode_clone);
            likesnode_before.parentNode.removeChild(likesnode_before);
              var xhr = new XMLHttpRequest();
              xhr.open("GET", "addlike.php?id_pic="+id, true);
              xhr.send();
        }
    else
        console.log("Veuillez vous connecter pour liker");
  }
  
  function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

  function addComment(id, addlikecom) {
      console.log(addlikecom);
    if (addlikecom === 1) 
        {
        let submit_comment = document.getElementById('submit_'+id);
        let text_input = submit_comment.previousSibling;
        text_input_value = htmlEntities(text_input.value);
        let new_comment = document.createElement('DIV');
        new_comment.setAttribute("class", "comment");
        new_comment.innerHTML = text_input_value;
        text_input.parentNode.insertBefore(new_comment, text_input);
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "addcomment.php?id_pic="+id+"&com="+text_input_value, true);
        // xhr.open("POST", "addcomment.php", true);
        xhr.send();
     }
    else
         alert("Veuillez vous connecter pour commenter");
}