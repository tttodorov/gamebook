package com.dao;

import com.model.Player;

import javax.ejb.Stateless;

/**
 * Data Access Object for students ( player == user in this context )
 */

@Stateless
public class PlayerDAO extends GenericDAO<Player> {

	public PlayerDAO(Class<Player> entityClass) {
		super(entityClass);
	}
}
