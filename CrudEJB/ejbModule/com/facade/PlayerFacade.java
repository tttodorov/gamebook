package com.facade;

import com.model.Player;

import javax.ejb.Local;

@Local
public interface PlayerFacade extends GenericFacade<Player> {

	public abstract Player find(int playerID);
}