package com.facade.impl;

import com.dao.PlayerDAO;
import com.facade.PlayerFacade;
import com.model.Player;

import javax.ejb.EJB;
import javax.ejb.Stateless;

@Stateless
public class PlayerFacadeImpl implements PlayerFacade {

	@EJB
	private PlayerDAO playerDAO;

	@Override
	public void save(Player player) {
		validate(player);

		playerDAO.save(player);
	}

	@Override
	public Player update(Player player) {
		validate(player);

		return playerDAO.update(player);
	}

	@Override
	public void delete(Player player) {
		playerDAO.delete(player.getId(), Player.class);
	}

	@Override
	public Player find(int playerID) {
		return playerDAO.find(playerID);
	}

	private void validate(Player player) {
		// TODO throw IllegalArgumentException, if player is not correct
	}

}
