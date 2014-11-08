package com.facade.impl;

import com.dao.GameDAO;
import com.facade.GameFacade;
import com.model.Game;

import javax.ejb.EJB;
import javax.ejb.Stateless;

@Stateless
public class GameFacadeImpl implements GameFacade {

	@EJB
	private GameDAO gameDAO;

	@Override
	public void save(Game game) {
		valid(game);
		gameDAO.save(game);
	}

	@Override
	public Game update(Game game) {
		valid(game);
		return gameDAO.update(game);
	}

	@Override
	public void delete(Game game) {
		gameDAO.delete(game.getId(), Game.class);
	}

	private void valid(Game game) {
		// TODO throw IllegalArgumentException, if player is not correct
	}

}
