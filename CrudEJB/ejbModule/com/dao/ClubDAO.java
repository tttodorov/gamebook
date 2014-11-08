package com.dao;

import com.model.Club;

import javax.ejb.Stateless;

@Stateless
public class ClubDAO extends GenericDAO<Club> {

	public ClubDAO(Class<Club> entityClass) {
		super(entityClass);
	}

}
