package com.dao;

import com.model.Game;

import javax.ejb.Stateless;

@Stateless
public class GameDAO extends GenericDAO<Game> {

	protected GameDAO(Class<Game> entityClass) {
		super(entityClass);
	}

}
