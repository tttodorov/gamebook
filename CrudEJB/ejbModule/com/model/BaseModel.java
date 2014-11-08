package com.model;

import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import java.util.Date;

@Entity
public abstract class BaseModel {

	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)
	protected int id;
	protected int is_active;
	protected final Date created_on;
	protected Date last_edited_on;

	protected BaseModel() {
		created_on = new Date();
	}

	protected void setId(int id) {
		this.id = id;
	}

	public int getId() {
		return id;
	}

	protected void setIs_active(int is_active) {
		this.is_active = is_active;
	}

	public int getIs_active() {
		return is_active;
	}

	public Date getCreated_on() {
		return created_on;
	}

	protected void setLast_edited_on(Date last_edited_on) {
		if (last_edited_on != null) {
			this.last_edited_on = last_edited_on;
		} else {
			this.last_edited_on = new Date();
		}
	}

	public Date getLast_edited_on() {
		return last_edited_on;
	}
}
