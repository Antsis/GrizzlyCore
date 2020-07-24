package one.wcz.mc.listeners;

import org.bukkit.Bukkit;
import org.bukkit.ChatColor;
import org.bukkit.Material;
import org.bukkit.command.Command;
import org.bukkit.command.CommandSender;
import org.bukkit.entity.EntityType;
import org.bukkit.entity.Player;
import org.bukkit.event.EventHandler;
import org.bukkit.event.Listener;
import org.bukkit.event.inventory.InventoryClickEvent;
import org.bukkit.event.inventory.InventoryType;
import org.bukkit.event.player.PlayerEggThrowEvent;
import org.bukkit.event.player.PlayerJoinEvent;
import org.bukkit.inventory.ItemStack;

public class listeners implements Listener {
	
	//判断物品lore是否有"感谢赞助玩家"
	@EventHandler
	public void onAnvil(InventoryClickEvent event) {
	    if (event.getRawSlot() == 2 && event.getWhoClicked() instanceof Player && event.getInventory().getType() == InventoryType.ANVIL) {
	    	ItemStack stack = event.getInventory().getContents()[0];
	    	if (stack != null && stack.getType() != Material.AIR && stack.hasItemMeta() && stack.getItemMeta().hasLore()) {
	    		 if (ChatColor.stripColor(stack.getItemMeta().getLore().toString()).contains("感谢赞助玩家") || ChatColor.stripColor(stack.getItemMeta().getLore().toString()).contains("无法用于铁砧")) {
	    			event.setCancelled(true);
	    		}
	    	}
	    }
	}
	//进服消息提示
	@EventHandler
	public void playerJoin(PlayerJoinEvent p) {
		if (p.getPlayer().hasPermission("vipjoin.1")) {
			p.setJoinMessage(null);
			Bukkit.broadcastMessage("§b§l§m                                                         ");
			Bukkit.broadcastMessage("§a§l        §e尊贵的"+ p.getPlayer().getName() +"§a玩家加入了游戏  ");
			Bukkit.broadcastMessage("§b§l§m                                                         ");
			return;
		}
	}
//	//禁止某世界发言
//	@EventHandler
//	public void onWorld(AsyncPlayerChatEvent e) {
//		Player p = e.getPlayer();
//		if (p.getWorld().getName().contains("world_him")) {
//			p.sendMessage("§7Him封住了你的嘴巴");
//			p.sendMessage("§7等待被Him支配吧");
//			e.setCancelled(true);
//		}
//	}
	//在玩家身边生成怪物
	@EventHandler
	public void onCommand(CommandSender sender, Command command, String commandLabel, String[] args) {
	}
	
	//蛋生成蝙蝠
	@EventHandler
	public void onChangeEggSpawn(PlayerEggThrowEvent e) {
		e.setHatching(true);
		e.setHatchingType(EntityType.BAT);
	}
}
