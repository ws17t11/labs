<?xml version="1.0" encoding="ISO-8859-1"?> 
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"> 
	<xsl:template match="/"> 
		<HTML> 
			<BODY> 
				<table border="1">
					<thead> <tr> 
						<th> Galdera </th>
						<th> Emaitza Zuzena </th>
						<th> Emaitza Okerrak </th>
						<th> Zailtasuna </th>
						<th> Gaia </th>
					</tr> </thead>
					<xsl:for-each select="/assessmentItems/assessmentItem">
						<tr> 
							<td> <FONT SIZE="2" COLOR="red" FACE="Verdana"> <xsl:value-of select="itemBody/p"/> </FONT> </td>
							<td> <FONT SIZE="2" COLOR="orange" FACE="Verdana"> <xsl:value-of select="correctResponse/value"/> </FONT> </td>
							<td> 
								<xsl:for-each select="incorrectResponses/value">
									<FONT SIZE="2" COLOR="green" FACE="Verdana"> <xsl:value-of select="."/> <br/> </FONT> 
								</xsl:for-each> 
							</td>
							<td> <FONT SIZE="2" COLOR="blue" FACE="Verdana"> <xsl:value-of select="@complexity"/> </FONT> </td>
							<td> <FONT SIZE="2" COLOR="purple" FACE="Verdana"> <xsl:value-of select="@subject"/> </FONT> </td>
						</tr>
					</xsl:for-each> 
				</table>
			</BODY> 
		</HTML> 
	</xsl:template> 
</xsl:stylesheet>