package com.model;

import javax.persistence.Entity;
import javax.persistence.Table;

@Entity
@Table(name = "GAME")
public class Game extends BaseModel {

	private String name;
	private String url;
	private String photo;
	private String players;
	private String club;
	private double rank;

	public String getName() {
		return name;
	}

	public void setName(String name) {
		if (name != null) {
			this.name = name;
		} else {
			this.name = "";
		}
	}

	public String getUrl() {
		return url;
	}

	public void setUrl(String url) {
		if (url != null) {
			this.url = url;
		} else {
			this.url = "";
		}

	}

	public String getPhoto() {
		return photo;
	}

	public void setPhoto(String photo) {
		if (photo != null) {
			this.photo = photo;
		} else {
			this.photo = "";
		}
	}

	public String getPlayers() {
		return players;
	}

	public void setPlayers(String players) {
		if (players != null) {
			this.players = players;
		} else {
			this.players = "";
		}
	}

	public String getClub() {
		return club;
	}

	public void setClub(String club) {
		if (club != null) {
			this.club = club;
		} else {
			this.club = "";
		}
	}

	public double getRank() {
		return rank;
	}

	public void setRank(double rank) {
		if (rank >= 0.0 && rank <= 100.0) {
			this.rank = rank;
		}
	}

}
