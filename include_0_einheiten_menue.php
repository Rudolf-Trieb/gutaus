	<li><a id="Womit" class="gutscheine-alle" href="">Gutscheine</a><span class="darrow">&#9660;</span>
		<ul class="sub1">
		
			<li>
				<a
					class=	<?php if (pruefe_ob_Herausger_der_ID_Einheit($_SESSION['UserID'],7)) 
									echo "'gutscheine-eigene'"; 
								else 
									echo "'gutscheine-fremd'";  
							?>
					href='Horus'>Horus
				</a>		
			</li>
			
			<li>
				<a class='gutscheine-eigene' >Meine eigenen-<br>Gutscheine</a>
			</li>
			
			<li>
				<a class='gutscheine-fremd' href='#'>Meine fremden-<br>Gutscheine</a>
			</li>
							
				
		</ul>
	</li>