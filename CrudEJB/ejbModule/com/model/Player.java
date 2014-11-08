package com.model;

import javax.persistence.Entity;
import javax.persistence.Table;

@Entity
@Table(name = "PLAYER")
public class Player extends BaseModel {

	private String username;
	private String password;
	private String email;
	private String given_name;
	private String photo;
	private String clubs;
	private String games;
	private double rank;

	public String getUsername() {
		return username;
	}

	public void setUsername(String username) {
		if (username != null) {
			this.username = username;
		} else {
			username = "";
		}
	}

	public String getPassword() {
		return password;
	}

	public void setPassword(String password) {
		if (password != null) {
			this.password = password;
		} else {
			password = "";
		}
	}

	public String getEmail() {
		return email;
	}

	public void setEmail(String email) {
		if (email != null) {
			this.email = email;
		} else {
			this.email = "";
		}
	}

	public String getGiven_name() {
		return given_name;
	}

	public void setGiven_name(String given_name) {
		if (given_name != null) {
			this.given_name = given_name;
		} else {
			this.given_name = "";
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

	public String getClubs() {
		return clubs;
	}

	public void setClubs(String clubs) {
		if (clubs != null) {
			this.clubs = clubs;
		} else {
			this.clubs = "";
		}
	}

	public String getGames() {
		return games;
	}

	public void setGames(String games) {
		if (games != null) {
			this.games = games;
		} else {
			this.games = "";
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

// package com.model;
//
// import javax.persistence.Column;
// import javax.persistence.Entity;
// import javax.persistence.GeneratedValue;
// import javax.persistence.GenerationType;
// import javax.persistence.Id;
// import javax.persistence.NamedQuery;
// import javax.persistence.Table;
//
// @Entity
// @Table(name = "USERS")
// @NamedQuery(name="User.findUserByEmail",
// query="select u from User u where u.email = :email")
// public class User {
//
// public static final String FIND_BY_EMAIL = "User.findUserByEmail";
//
// @Id
// @GeneratedValue(strategy=GenerationType.AUTO)
// private int id;
//
// @Column(unique = true)
// private String email;
// private String password;
// private String name;
// private String role;
//
// public int getId() {
// return id;
// }
//
// public void setId(int id) {
// this.id = id;
// }
//
// public String getEmail() {
// return email;
// }
//
// public void setEmail(String email) {
// this.email = email;
// }
//
// public String getPassword() {
// return password;
// }
//
// public void setPassword(String password) {
// this.password = password;
// }
//
// public String getName() {
// return name;
// }
//
// public void setName(String name) {
// this.name = name;
// }
//
// public String getRole() {
// return role;
// }
//
// public void setRole(String role) {
// this.role = role;
// }
//
// @Override
// public int hashCode() {
// return getId();
// }
//
// @Override
// public boolean equals(Object obj) {
// if(obj instanceof User){
// User user = (User) obj;
// return user.getEmail().equals(getEmail());
// }
//
// return false;
// }
// }
//
//
// package com.model;
//
// import javax.persistence.Entity;
// import javax.persistence.GeneratedValue;
// import javax.persistence.GenerationType;
// import javax.persistence.Id;
// import javax.persistence.Table;
//
// @Entity
// @Table(name = "DOGS")
// public class Dog {
//
// @Id
// @GeneratedValue(strategy = GenerationType.AUTO)
// private int id;
// private String name;
// private double weight;
//
// public int getId() {
// return id;
// }
//
// public void setId(int id) {
// this.id = id;
// }
//
// public String getName() {
// return name;
// }
//
// public void setName(String name) {
// this.name = name;
// }
//
// public double getWeight() {
// return weight;
// }
//
// public void setWeight(double weight) {
// this.weight = weight;
// }
//
// @Override
// public int hashCode() {
// return getId();
// }
//
// @Override
// public boolean equals(Object obj) {
//
// if(obj instanceof Dog){
// Dog dog = (Dog) obj;
// return dog.getId() == getId();
// }
//
// return false;
// }
// }
