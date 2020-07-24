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
	
	//�ж���Ʒlore�Ƿ���"��л�������"
	@EventHandler
	public void onAnvil(InventoryClickEvent event) {
	    if (event.getRawSlot() == 2 && event.getWhoClicked() instanceof Player && event.getInventory().getType() == InventoryType.ANVIL) {
	    	ItemStack stack = event.getInventory().getContents()[0];
	    	if (stack != null && stack.getType() != Material.AIR && stack.hasItemMeta() && stack.getItemMeta().hasLore()) {
	    		 if (ChatColor.stripColor(stack.getItemMeta().getLore().toString()).contains("��л�������") || ChatColor.stripColor(stack.getItemMeta().getLore().toString()).contains("�޷���������")) {
	    			event.setCancelled(true);
	    		}
	    	}
	    }
	}
	//������Ϣ��ʾ
	@EventHandler
	public void playerJoin(PlayerJoinEvent p) {
		if (p.getPlayer().hasPermission("vipjoin.1")) {
			p.setJoinMessage(null);
			Bukkit.broadcastMessage("��b��l��m                                                         ");
			Bukkit.broadcastMessage("��a��l        ��e����"+ p.getPlayer().getName() +"��a��Ҽ�������Ϸ  ");
			Bukkit.broadcastMessage("��b��l��m                                                         ");
			return;
		}
	}
//	//��ֹĳ���緢��
//	@EventHandler
//	public void onWorld(AsyncPlayerChatEvent e) {
//		Player p = e.getPlayer();
//		if (p.getWorld().getName().contains("world_him")) {
//			p.sendMessage("��7Him��ס��������");
//			p.sendMessage("��7�ȴ���Him֧���");
//			e.setCancelled(true);
//		}
//	}
	//�����������ɹ���
	@EventHandler
	public void onCommand(CommandSender sender, Command command, String commandLabel, String[] args) {
	}
	
	//����������
	@EventHandler
	public void onChangeEggSpawn(PlayerEggThrowEvent e) {
		e.setHatching(true);
		e.setHatchingType(EntityType.BAT);
	}
}
