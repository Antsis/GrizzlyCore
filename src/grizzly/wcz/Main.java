package grizzly.wcz;

import org.bukkit.Bukkit;
import org.bukkit.plugin.java.JavaPlugin;

import grizzly.wcz.listeners.listeners;

public class Main extends JavaPlugin {
	@Override
	public void onEnable () {
		getServer().getConsoleSender().sendMessage("§aGrizzly §6>>> §a插件成功加载");
		Bukkit.getPluginManager().registerEvents(new listeners(), this);
	}
	@Override
	public void onDisable () {
		getServer().getConsoleSender().sendMessage("§aGrizzly §6>>> §a插件成功加载");
	}
}
