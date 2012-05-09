<?php

	include_once ('./orm/bootstrap.php');
	
	function addNote($film_id, $user_id, $note_val, $note_commentaire)
	{
		Doctrine_Core :: loadModels('./models');
		$note = new Note();
		$note['film_id'] = $film_id;
		$note['user_id'] = $user_id;
		$note['note_val'] =  $note_val;
		$note['note_commentaire'] =  $note_commentaire;
		$note->save();
	}
	
	function getAllNotes()
	{
		Doctrine_Core :: loadModels('./models');
		$listeNotes = Doctrine_Core :: getTable ( 'Note' )->findAll(null);	
		$listeNotes = $listeNotes->getData();
		$liste = array();
		foreach ($listeNotes as $note){
			$note = $note->getData();
			$liste[] = $note;
		}
		if(count($listeNotes) == 0)
			return null;
		return $liste;
	}
	
	function getNoteById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$note = Doctrine_Core :: getTable ( 'Note' )->findBy('note_id', $id ,null);	
		$note = $note->getData();
		if(count($note) == 0)
			return null;
		return $note[0];
	}
	
	function getNotesByFilmId($film_id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeNotes = Doctrine_Core :: getTable ( 'Note' )->findBy('film_id', $film_id ,null);	
		$listeNotes = $listeNotes->getData();
		if(count($listeNotes) == 0)
			return null;
		return $listeNotes;
	}	
	
	function getNotesByUserId($user_id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeNotes = Doctrine_Core :: getTable ( 'Note' )->findBy('user_id', $user_id ,null);	
		$listeNotes = $listeNotes->getData();
		if(count($listeNotes) == 0)
			return null;
		return $listeNotes[0];
	}
	
	function getNoteByFilmIdAndUserId($film_id, $user_id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeNotesByFilmId = getNotesByFilmId($film_id);	
		if(count($listeNotesByFilmId) == 0)
			return null;
		else{
			foreach ($listeNotesByFilmId as $noteByFilm){
				if($noteByFilm['user_id'] == $user_id){
					return $noteByFilm[0];
				}
			}
		}
	}
	
	function getNotesValByFilmId($film_id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeNotes = Doctrine_Core :: getTable ( 'Note' )->findBy('film_id', $film_id ,null);	
		$listeNotes = $listeNotes->getData();
		$listeNotesVal = array();
		if(count($listeNotes) == 0)
			return null;
		else{
			foreach ($listeNotes as $note){
				$listeNotesVal[] = $note['note_val'];
			}
			return $listeNotesVal;
		}
	}
	
	function getNotesValByUserId($user_id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeNotes = Doctrine_Core :: getTable ( 'Note' )->findBy('user_id', $user_id ,null);	
		$listeNotes = $listeNotes->getData();
		$listeNotesVal = array();
		if(count($listeNotes) == 0)
			return null;
		else{
			foreach ($listeNotes as $note){
				$listeNotesVal[] = $note['note_val'];
			}
			return $listeNotesVal;
		}
	}
	
	function getNoteValByFilmIdAndUserId($film_id, $user_id)
	{
		$listeNotes = getNoteByFilmIdAndUserId($film_id, $user_id);
		$listeNotesVal = array();
		if(count(listeNotes) > 0){
			foreach ($listeNotes as $note)
				$listeNotesVal[] = $note['note_val'];
			return $listeNotesVal;
		}
		else
			return null;
	}
	
	function getNotesCommentairesByFilmId($film_id)
	{
		$listeNotes = getNotesByFilmId($film_id);
		$listeNotesCommentaires = array();
		if(count($listeNotes) > 0){
			foreach ($listeNotes as $note)
				$listeNotesCommentaires[] = $note['note_commentaire'];
			return $listeNotesCommentaires;
		}
		else
			return null;
	}
	
	function getNotesCommentairesByUserId($user_id)
	{
		$listeNotes = getNotesByUserId($user_id);
		$listeNotesCommentaires = array();
		if(count($listeNotes) > 0){
			foreach ($listeNotes as $note)
				$listeNotesCommentaires[] = $note['note_commentaire'];
			return $listeNotesCommentaires;
		}
		else
			return null;
	}
	
	function getNoteCommentairesByFilmIdAndUserId($film_id, $user_id)
	{
		$listeNotes = getNoteByFilmIdAndUserId($film_id, $user_id);
		$listeNotesCommentaires = array();
		if(count($listeNotes) > 0){
			foreach ($listeNotes as $note)
				$listeNotesCommentaires = $note['note_commentaire'];
			return $listeNotesCommentaires;
		}
		else
			return null;
	}
	
	function setNoteValByFilmIdAndUserId($film_id, $user_id, $note_val)
	{
		if($note_val >= 0 && $note_val <= MAX_RATING){
			Doctrine_Core :: loadModels('./models');
			$note = getNoteByFilmIdAndUserId($film_id, $user_id);
			if(count($note) == 1){
				$note['note_val'] = $note_val;
				$note->save();
				return 1;
			}
		}else{
			return null;
		}
	}

	function setNoteCommentaireByFilmIdAndUserId($film_id, $user_id, $note_commentaire)
	{
		if($note_val >= 0 && $note_val <= MAX_RATING){
			Doctrine_Core :: loadModels('./models');
			$note = getNoteByFilmIdAndUserId($film_id, $user_id);
			if(count($note) == 1){
				$note['note_commentaire'] = $note_commentaire;
				$note->save();
				return 1;
			}
		}else{
			return null;
		}
	}
	
	function deleteNoteById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$note = getNoteById($id);
		if($note != -1){
			$note->delete();
			return 1;
		}else{
			return null;
		}
	}
	
	function deleteNoteByFilmIdAndUserId($film_id, $user_id)
	{
		Doctrine_Core :: loadModels('./models');
		$note = getNoteByFilmIdAndUserId($film_id, $user_id);
		if($note != -1){
			$note->delete();
			return 1;
		}else{
			return null;
		}
	}
	
?>