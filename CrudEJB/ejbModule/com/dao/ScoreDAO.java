package com.dao;

import com.model.Score;

import javax.ejb.Stateless;

@Stateless
public class ScoreDAO extends GenericDAO<Score> {

	protected ScoreDAO(Class<Score> entityClass) {
		super(entityClass);
	}

}
