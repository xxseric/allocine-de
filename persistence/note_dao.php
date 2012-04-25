<?php

	include_once ('../orm/bootstrap.php');
	require_once '../config.php';
	
	function addNote($film_id, $user_id=null, $note_val, $note_commentaire=null)
	{
		Doctrine_Core :: loadModels('../models');
		$isExisting = getNoteByFilmIdAndUserId($film_id, $user_id);
		if($user_id != null && $isExisting == -1){
			$note = new Note();
			$note['film_id'] = $film_id;
			$note['user_id'] = $user_id;
			$note['note_val'] =  $note_val;
			$note['note_commentaire'] =  $note_commentaire;
			$note->save();
			return 1;
		}else{
			return -1;
		}
	}
	
	function getNoteById($id)
	{
		Doctrine_Core :: loadModels('../models');
		$note = Doctrine_Core :: getTable ( 'Note' )->findBy('note_id', $id ,null);	
		$note = $note->getData();
		if(count($note) == 0)
			return -1;
		return $note;
	}
	
	function getNotesByFilmId($film_id)
	{
		Doctrine_Core :: loadModels('../models');
		$listeNotes = Doctrine_Core :: getTable ( 'Note' )->findBy('film_id', $film_id ,null);	
		$listeNotes = $listeNotes->getData();
		if(count($listeNotes) == 0)
			return -1;
		return $listeNotes;
	}	
	
	function getNotesByUserId($user_id)
	{
		Doctrine_Core :: loadModels('../models');
		$listeNotes = Doctrine_Core :: getTable ( 'Note' )->findBy('user_id', $user_id ,null);	
		$listeNotes = $listeNotes->getData();
		if(count($listeNotes) == 0)
			return -1;
		return $listeNotes;
	}
	
	function getNoteByFilmIdAndUserId($film_id, $user_id)
	{
		Doctrine_Core :: loadModels('../models');
		$listeNotes = array();
		$listeNotesByFilmId = getNotesByFilmId($film_id);	
		foreach ($listeNotesByFilmId as $noteByFilm){
			if($noteByFilm['user_id'] == $user_id){
				$listeNotes[] = $noteByFilm;
			}
		}
		if(count($listeNotes) > 0)
			return $listeNotes;
		else
			return -1;
	}
	
	function getNotesValByFilmId($film_id)
	{
		Doctrine_Core :: loadModels('../models');
		$listeNotes = Doctrine_Core :: getTable ( 'Note' )->findBy('film_id', $film_id ,null);	
		$listeNotes = $listeNotes->getData();
		$listeNotesVal = array();
		if(count($listeNotes) == 0)
			return -1;
		else{
			foreach ($listeNotes as $note){
				$listeNotesVal[] = $note['note_val'];
			}
			return $listeNotesVal;
		}
	}
	
	function getNotesValByUserId($user_id)
	{
		Doctrine_Core :: loadModels('../models');
		$listeNotes = Doctrine_Core :: getTable ( 'Note' )->findBy('user_id', $user_id ,null);	
		$listeNotes = $listeNotes->getData();
		$listeNotesVal = array();
		if(count($listeNotes) == 0)
			return -1;
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
			return -1;
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
			return -1;
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
			return -1;
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
			return -1;
	}
	
	function setNoteValByFilmIdAndUserId($film_id, $user_id, $note_val)
	{
		if($note_val >= 0 && $note_val <= MAX_RATING){
			Doctrine_Core :: loadModels('../models');
			$note = getNoteByFilmIdAndUserId($film_id, $user_id);
			if(count($note) == 1){
				$note['note_val'] = $note_val;
				$note->save();
				return 1;
			}
		}else{
			return -1;
		}
	}

	function setNoteCommentaireByFilmIdAndUserId($film_id, $user_id, $note_commentaire)
	{
		if($note_val >= 0 && $note_val <= MAX_RATING){
			Doctrine_Core :: loadModels('../models');
			$note = getNoteByFilmIdAndUserId($film_id, $user_id);
			if(count($note) == 1){
				$note['note_commentaire'] = $note_commentaire;
				$note->save();
				return 1;
			}
		}else{
			return -1;
		}
	}
	
	function deleteNoteById($id)
	{
		Doctrine_Core :: loadModels('../models');
		$note = getNoteById($id);
		if($note != -1){
			$note->delete();
			return 1;
		}else{
			return -1;
		}
	}
	
	function deleteNoteByFilmIdAndUserId($film_id, $user_id)
	{
		Doctrine_Core :: loadModels('../models');
		$note = getNoteByFilmIdAndUserId($film_id, $user_id);
		if($note != -1){
			$note->delete();
			return 1;
		}else{
			return -1;
		}
	}
	
?>